<?php
namespace xz1mefx\multilang\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Url;

/**
 * Class SeoLangs
 * @package xz1mefx\multilang\widgets
 */
class SeoLangs extends Widget
{
    /**
     * @var string
     */
    public $alternateLinkTemplate = "<link rel=\"alternate\" hreflang=\"{hreflang}\" href=\"{href}\"/>";

    /**
     * @return string
     */
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
