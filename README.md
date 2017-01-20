Multilanguage tools package for yii2
=======================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-packagist]

The extension is a package of tools to implement multilanguage in Yii2 project:
- Automatically redirects the user to the URL selected (automatically or manually) language and remembers the user selected language
- Automatically collect all new translates into DB
- Has a widget to set a correct hreflang attributes
- Provides a CRUD actions for edit the list of languages and the interface translations
- Has a widget to create language selector (for adminlte theme)
- Has a `@weblang\` alias with current language

Installation
------------

1.  The preferred way to install this extension is through [composer](http://getcomposer.org/download/), run:
    ```bash
    php composer.phar require --prefer-dist xz1mefx/yii2-multilang "~1"
    ```

1.  Execute migration:
    ```bash
    php yii migrate --migrationPath=@vendor/xz1mefx/yii2-multilang/migrations --interactive=0
    ```
    or you can create new migration and extend it, example:
    ```php
    require(Yii::getAlias('@vendor/xz1mefx/yii2-multilang/migrations/m161210_131014_multilang_init.php'));

    /**
    * Class m161221_135351_multilang_init
    */
    class m161221_135351_multilang_init extends m161210_131014_multilang_init
    {
    }
    ```

1.  Add new multilangCache component to common config file:
    ```php
    'multilangCache' => [
        'class' => \xz1mefx\multilang\caching\MultilangCache::className(),
    ],
    ```

1.  Override components in common config file:
    ```php
    'urlManager' => [
        'class' => \xz1mefx\multilang\web\UrlManager::className(),
    ],
    'request' => [
        'class' => \xz1mefx\multilang\web\Request::className(),
    ],
    'i18n' => [
        'class' => \xz1mefx\multilang\i18n\I18N::className(),
    ],
    'lang' => [
        'class' => \xz1mefx\multilang\components\Lang::className(),
    ],
    ```

1.  [*not necessary*] If you use [`iiifx-production/yii2-autocomplete-helper`][link-autocomplete-extension] you need to run:
    ```bash
    composer autocomplete
    ```

1.  Override some components in console config file:
    ```php
    'request' => [ // override common config
        'class' => 'yii\console\Request',
    ],
    'urlManager' => [], // override common config
    'i18n' => [], // override common config
    ```

1.  Add HrefLangs widget to page `<head></head>` section in layout(s):
    ```php
    <?= \xz1mefx\multilang\widgets\HrefLangs::widget() ?>
    ```

1.  Add LanguageController (or another) with next code:
    ```php
    use xz1mefx\multilang\actions\language\IndexAction;
    use xz1mefx\multilang\actions\language\CreateAction;
    use xz1mefx\multilang\actions\language\UpdateAction;
    use xz1mefx\multilang\actions\language\DeleteAction;
    
    ...
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
    //          'theme' => IndexAction::THEME_ADMINLTE,
    //          'canAdd' => false,
    //          'canUpdate' => false,
    //          'canDelete' => false,
            ],
            'create' => [
                'class' => CreateAction::className(),
    //          'theme' => CreateAction::THEME_ADMINLTE,
            ],
            'update' => [
                'class' => UpdateAction::className(),
    //           'theme' => UpdateAction::THEME_ADMINLTE,
            ],
            'delete' => [
                'class' => DeleteAction::className(),
    //           'theme' => DeleteAction::THEME_ADMINLTE,
            ],
        ];
    }
    ```
    , where you can change action theme (`THEME_BOOTSTRAP` - *by default* or [`THEME_ADMINLTE`][link-adminlte-extension])
    , view path and access to controls in index action.
    
    This controller will control system languages.

1.  Add TranslationController (or another) with next code:
    ```php
    use xz1mefx\multilang\actions\translation\IndexAction;
    use xz1mefx\multilang\actions\translation\UpdateAction;
    
    ...
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
    //          'theme' => IndexAction::THEME_ADMINLTE,
    //          'canUpdate' => false,
            ],
            'update' => [
                'class' => UpdateAction::className(),
    //          'theme' => UpdateAction::THEME_ADMINLTE,
            ],
        ];
    }
    ```
    , where you can change action theme (`THEME_BOOTSTRAP` - *by default* or [`THEME_ADMINLTE`][link-adminlte-extension])
    , view path and access to controls in index action.
    
    This controller will control interface translations.

1.  [*not necessary, only for adminlte theme*] Add language selector widget into `header ul.nav`:
    ```php
    <?= \xz1mefx\multilang\widgets\adminlte\HeaderDropDownLangSelector::widget() ?>
    ```
    
AdminLTE theme you can found in [`xz1mefx/yii2-adminlte` package][link-adminlte-extension].

[ico-version]: https://img.shields.io/github/release/xz1mefx/yii2-multilang.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-downloads]: https://img.shields.io/packagist/dt/xz1mefx/yii2-multilang.svg

[link-packagist]: https://packagist.org/packages/xz1mefx/yii2-multilang
[link-adminlte-extension]: https://github.com/xZ1mEFx/yii2-adminlte
[link-autocomplete-extension]: https://github.com/iiifx-production/yii2-autocomplete-helper
