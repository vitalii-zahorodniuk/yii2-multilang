<?php
namespace xz1mefx\multilang\i18n;

/**
 * @inheritdoc
 */
class I18N extends \yii\i18n\I18N
{

    /**
     * @inheritdoc
     */
    public $translations;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->translations)) {
            $this->translations = [
                '*' => [
                    'class' => DbMessageSource::className(),
                ],
                'app' => [
                    'class' => DbMessageSource::className(),
                ],
                'yii' => [
                    'class' => DbMessageSource::className(),
                ],
            ];
        }
        parent::init();
    }
}
