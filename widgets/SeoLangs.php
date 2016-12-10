<?php
namespace xz1mefx\multilang\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Url;

class SeoLangs extends Widget
{
    public $alternateLinkTemplate = "<link rel=\"alternate\" hreflang=\"{hreflang}\" href=\"{href}\"/>";

    public function run()
    {
        $content = '';
        if (Yii::$app->lang->enabled()) {
            $content .= strtr($this->alternateLinkTemplate, ['{hreflang}' => 'x-default', '{href}' => Url::home(true)]);
            foreach (Yii::$app->lang->langList as $lang) {
                $content .= strtr($this->alternateLinkTemplate, ['{hreflang}' => $lang['url'], '{href}' => Url::home(true) . $lang['url']]);
            }
        }
        return $content;
    }
}
