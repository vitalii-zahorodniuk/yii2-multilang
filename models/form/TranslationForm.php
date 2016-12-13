<?php

namespace xz1mefx\multilang\models\form;

use xz1mefx\multilang\models\Message;
use xz1mefx\multilang\models\SourceMessage;
use Yii;

/**
 * Class TranslationForm
 *
 * @property array $langs
 *
 * @package xz1mefx\multilang\models\form
 */
class TranslationForm extends SourceMessage
{

    /**
     * @var array attribute values indexed by attribute names
     */
    public $langs = [];

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();

        // Init langs
        foreach ($this->getLangListArray() as $key => $lang) {
            $this->langs[$key] = $this->getTranslationByLocal($lang['locale']);
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        // Clear app cache
        // TODO: Try to clear only needed cache
        Yii::$app->cache->flush();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['langs', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['langs'] = Yii::t('backend_translation', 'Language');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    function save($runValidation = true, $attributeNames = NULL)
    {
        foreach ($this->getLangListArray() as $key => $value) {
            $message = Message::findOne(['id' => $this->id, 'language' => $value['locale']]);
            if (!isset($message)) {
                $message = new Message();
            }
            $message->id = $this->id;
            $message->language = $value['locale'];
            $message->translation = isset($this->langs[$key]) ? $this->langs[$key] : '';
            if (!$message->save()) {
                return false;
            }
        }
        return true;
    }

}
