<?php

namespace common\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Url;

class SeoLangs extends Widget
{

    public function run()
    {
        if (Yii::$app->lang->enabled()) {
            $langs = [];
            foreach (Yii::$app->lang->langList as $lang) {
                $langs[$lang['url']] = Url::home(true) . $lang['url'];
            }
            return $this->render('hrefLangs/view', [
                'home' => Url::home(true),
                'langs' => $langs,
            ]);
        }
    }

}
