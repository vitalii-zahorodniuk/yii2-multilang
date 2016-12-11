<?php
namespace xz1mefx\multilang\i18n;

use Yii;
use yii\db\Query;
use yii\i18n\MissingTranslationEvent;

class DbMessageSource extends \yii\i18n\DbMessageSource
{
    /**
     * @var boolean whether to enable caching translated messages
     */
    public $enableCaching = true;

    /**
     * @var boolean whether to force message translation when the source and target languages are the same.
     * Defaults to false, meaning translation is only performed when source and target languages are different.
     */
    public $forceTranslation = true;

    private $_messages = [];

    /**
     * Translates the specified message.
     * If the message is not found, a [[EVENT_MISSING_TRANSLATION|missingTranslation]] event will be triggered.
     * If no translation for current message this method will save empty record in db & return `false`.
     * @param string $category the category that the message belongs to.
     * @param string $message the message to be translated.
     * @param string $language the target language.
     * @return string|boolean the translated message or false if translation wasn't found.
     */
    protected function translateMessage($category, $message, $language)
    {
        $key = $language . '/' . $category;
        // load messages if need
        if (!isset($this->_messages[$key])) {
            $this->_messages[$key] = $this->loadMessages($category, $language);
        }
        // get translation if it exist
        if (!empty($this->_messages[$key][$message])) {
            return $this->_messages[$key][$message];
        }
        // calling event
        if ($this->hasEventHandlers(self::EVENT_MISSING_TRANSLATION)) {
            $event = new MissingTranslationEvent([
                'category' => $category,
                'message' => $message,
                'language' => $language,
            ]);
            $this->trigger(self::EVENT_MISSING_TRANSLATION, $event);
        }
        $needUpdateCache = false;
        // create source message in DB if need
        $sourceMsgId = $this->getSourceMessageId($category, $message);
        if (!isset($this->_messages[$key][$message])) {
            if ($sourceMsgId == 0) {
                Yii::$app->db->createCommand()->insert($this->sourceMessageTable, [
                    'category' => $category,
                    'message' => $message,
                ])->execute();
                $sourceMsgId = Yii::$app->db->getLastInsertID();
            }
            // update messages array
            $this->_messages[$key][$message] = NULL;
            $needUpdateCache = true;
        }
        // create message in DB if need
        if ($this->_messages[$key][$message] === NULL || $this->_messages[$key][$message] !== '') {
            Yii::$app->db->createCommand()->insert($this->messageTable, [
                'id' => $sourceMsgId,
                'language' => $language,
                'translation' => '',
            ])->execute();
            // update messages array
            $this->_messages[$key][$message] = '';
            $needUpdateCache = true;
        }
        // rewrite cache if need
        if ($needUpdateCache && $this->enableCaching) {
            $this->cache->set([
                __CLASS__,
                $category,
                $language,
            ], $this->_messages[$key], $this->cachingDuration);
        }

        return false;
    }

    /**
     * Loads the message translation for the specified language and category.
     * If translation for specific locale code such as `en-US` isn't found it
     * tries more generic `en`.
     *
     * @param string $category the message category
     * @param string $language the target language
     * @return array the loaded messages. The keys are original messages, and the values
     * are translated messages.
     */
    protected function loadMessages($category, $language)
    {
        if ($this->enableCaching) {
            $key = [
                __CLASS__,
                $category,
                $language,
            ];
            $messages = $this->cache->get($key);
            if ($messages === false) {
                $messages = $this->loadMessagesFromDb($category, $language);
                $this->cache->set($key, $messages, $this->cachingDuration);
            }

            return $messages;
        } else {
            return $this->loadMessagesFromDb($category, $language);
        }
    }

    /**
     * Try to get source message id from db
     * @param string $category the category that the message belongs to
     * @param string $message the message to be translated
     * @return integer source message id or 0 if record not found
     */
    private function getSourceMessageId($category, $message)
    {
        $query = new Query();
        $query->select('[[id]]')
            ->from($this->sourceMessageTable)
            ->where('BINARY [[category]]=:category AND BINARY [[message]]=:message')
            ->params([
                ':category' => $category,
                ':message' => $message,
            ]);
        return (int)$query->createCommand(\Yii::$app->db)->queryScalar();
    }

}
