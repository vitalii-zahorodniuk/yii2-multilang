<?php
namespace xz1mefx\multilang\i18n;

use xz1mefx\multilang\models\Message;
use xz1mefx\multilang\models\SourceMessage;
use Yii;
use yii\caching\Cache;
use yii\db\Query;
use yii\i18n\MissingTranslationEvent;

class DbMessageSource extends \yii\i18n\DbMessageSource
{
    /**
     * @var boolean whether to enable caching translated messages
     */
    public $enableCaching = TRUE;

    /**
     * @var boolean whether to force message translation when the source and target languages are the same.
     * Defaults to false, meaning translation is only performed when source and target languages are different.
     */
    public $forceTranslation = TRUE;

    /**
     * @var Cache|array|string the cache object or the application component ID of the cache object.
     * The messages data will be cached using this cache object.
     * Note, that to enable caching you have to set [[enableCaching]] to `true`, otherwise setting this property has no
     * effect.
     *
     * After the DbMessageSource object is created, if you want to change this property, you should only assign
     * it with a cache object.
     *
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     * @see cachingDuration
     * @see enableCaching
     */
    public $cache = 'multilangCache';

    /**
     * @var string the name of the source message table.
     */
    public $sourceMessageTable = SourceMessage::TABLE_NAME;

    /**
     * @var string the name of the translated message table.
     */
    public $messageTable = Message::TABLE_NAME;

    private $_messages = [];

    /**
     * Translates the specified message.
     * If the message is not found, a [[EVENT_MISSING_TRANSLATION|missingTranslation]] event will be triggered.
     * If no translation for current message this method will save empty record in db & return `false`.
     *
     * @param string $category the category that the message belongs to.
     * @param string $message  the message to be translated.
     * @param string $language the target language.
     *
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
        // if message is not exist
        if (!array_key_exists($message, $this->_messages[$key])) {
            // try to get source message id from db
            $sourceMsgId = $this->getSourceMessageId($category, $message);
            // if source message id was not found -> create new source message an get it id
            if ($sourceMsgId == 0) {
                Yii::$app->db->createCommand()->insert($this->sourceMessageTable, [
                    'category' => $category,
                    'message' => $message,
                ])->execute();
                $sourceMsgId = Yii::$app->db->getLastInsertID();
            }
            // insert new source message into db
            Yii::$app->db->createCommand()->insert($this->messageTable, [
                'id' => $sourceMsgId,
                'language' => $language,
                'translation' => '',
            ])->execute();
            // update messages array
            $this->_messages[$key][$message] = '';
            // rewrite cache if need
            if ($this->enableCaching) {
                $this->cache->set([
                    __CLASS__,
                    $category,
                    $language,
                ], $this->_messages[$key], $this->cachingDuration);
            }
        }

        return FALSE;
    }

    /**
     * Loads the message translation for the specified language and category.
     * If translation for specific locale code such as `en-US` isn't found it
     * tries more generic `en`.
     *
     * @param string $category the message category
     * @param string $language the target language
     *
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
            if ($messages === FALSE) {
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
     *
     * @param string $category the category that the message belongs to
     * @param string $message  the message to be translated
     *
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
