<?php
namespace xz1mefx\multilang\widgets;

use Yii;
use yii\bootstrap\Widget;
use xz1mefx\base\helpers\Url;

/**
 * Class HrefLangs
 * @package xz1mefx\multilang\widgets
 */
class HrefLangs extends Widget
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
            $content .= strtr($this->alternateLinkTemplate, ['{hreflang}' => 'x-default', '{href}' => Url::home(TRUE)]);
            foreach (Yii::$app->lang->langList as $lang) {
                $content .= strtr($this->alternateLinkTemplate, ['{hreflang}' => $lang['url'], '{href}' => Url::home(TRUE) . $lang['url']]);
            }
        }
        return $content;
    }
}
