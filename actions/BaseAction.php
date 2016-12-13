<?php
namespace xz1mefx\multilang\actions;

use yii\base\Action;

/**
 * Class BaseAction
 * @package xz1mefx\multilang\actions\lang
 */
class BaseAction extends Action
{

    const THEME_BOOTSTRAP = 'bootstrap';
    const THEME_ADMINLTE = 'adminlte';

    public $theme = self::THEME_BOOTSTRAP;
    public $view = NULL;

}
