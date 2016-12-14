<?php
namespace xz1mefx\multilang\widgets\adminlte;

use Yii;
use yii\bootstrap\Widget;

/**
 * Class HeaderDropDownSelector
 * @package xz1mefx\multilang\widgets
 */
class HeaderDropDownSelector extends Widget
{
    /**
     * @var string
     */
    public $commonTemplate = <<<HTML
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {currentLang}
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu" style="min-width: inherit;">{languagesList}</ul>
</li>
HTML;

    /**
     * @var string
     */
    public $langItemTemplate = <<<HTML
<li><a href="{languageLink}">{languageName}</a></li>
HTML;


    /**
     * @return string
     */
    public function run()
    {
        $content = '';
        if (Yii::$app->lang->enabled()) {
            $languagesList = '';
            foreach (Yii::$app->lang->langList as $lang) {
                $languagesList .= strtr($this->langItemTemplate, [
                    '{languageLink}' => Yii::$app->lang->getCurrentUrlWithLang($lang['url']),
                    '{languageName}' => strtoupper($lang['url']),
                ]);
            }
            if (empty($languagesList)) {
                return $content;
            }
            $content .= strtr($this->commonTemplate, [
                '{currentLang}' => strtoupper(Yii::$app->lang->getDDLang()),
                '{languagesList}' => $languagesList,
            ]);
        }
        return $content;
    }
}
