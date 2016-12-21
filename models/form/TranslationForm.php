<?php

namespace xz1mefx\multilang\models\form;

use xz1mefx\multilang\models\Language;
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
        foreach (Language::getLangListArray() as $key => $lang) {
            $this->langs[$key] = $this->getTranslationByLocal($lang['locale']);
        }
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
        $attributeLabels['langs'] = Yii::t('multilang-tools', 'Language');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    function save($runValidation = TRUE, $attributeNames = NULL)
    {
        foreach (Language::getLangListArray() as $key => $value) {
            $message = Message::findOne(['id' => $this->id, 'language' => $value['locale']]);
            if (!isset($message)) {
                $message = new Message();
            }
            $message->id = $this->id;
            $message->language = $value['locale'];
            $message->translation = isset($this->langs[$key]) ? $this->langs[$key] : '';
            if (!$message->save()) {
                return FALSE;
            }
        }
        return TRUE;
    }

}
