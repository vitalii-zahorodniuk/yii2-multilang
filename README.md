Multilanguage tools package for yii2
=======================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

1.  run
    ```bash
    php composer.phar require --prefer-dist xz1mefx/yii2-multilang "1.0.0-rc"
    ```

2.  execute migration:
    ```bash
    php yii migrate --migrationPath=@vendor/xz1mefx/yii2-multilang/migrations --interactive=0
    ```

3.  add components to common config file (or change classes of components):
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

4.  if you use `iiifx-production/yii2-autocomplete-helper` you need to run:
    ```bash
    composer autocomplete
    ```

5.  override components in console config file:
    ```php
    'request' => [ // override common config
        'class' => 'yii\console\Request',
    ],
    'urlManager' => [], // override common config
    'i18n' => [], // override common config
    ```

6.  add SeoLangs widget to page `<head></head>` section in layout(s):
    ```php
    <?= \xz1mefx\multilang\widgets\SeoLangs::widget() ?>
    ```

7.  add LangController (or another) with next code:
    ```php
    use xz1mefx\multilang\actions\lang\CreateAction;
    use xz1mefx\multilang\actions\lang\DeleteAction;
    use xz1mefx\multilang\actions\lang\IndexAction;
    use xz1mefx\multilang\actions\lang\UpdateAction;
    
    ...
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'put', 'post'],
                    'delete' => ['post', 'delete'],
                ],
            ],
        ];
    }
    
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
    , where you can change action theme (`IndexAction::THEME_BOOTSTRAP` - *by default* or `IndexAction::THEME_ADMINLTE`)
    , view path and access to controls in index action.
    
    AdminLTE theme you can found in `xz1mefx/yii2-adminlte` package.

[ico-version]: https://img.shields.io/packagist/v/xz1mefx/yii2-multilang.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-downloads]: https://img.shields.io/packagist/dt/xz1mefx/yii2-multilang.svg
[ico-travis]: https://travis-ci.org/xz1mefx/yii2-multilang.svg
[ico-scrutinizer]: https://scrutinizer-ci.com/g/xz1mefx/yii2-multilang/badges/quality-score.png?b=master
[ico-codecoverage]: https://scrutinizer-ci.com/g/xz1mefx/yii2-multilang/badges/coverage.png?b=master

[link-packagist]: https://packagist.org/packages/xz1mefx/yii2-multilang
[link-downloads]: https://packagist.org/packages/xz1mefx/yii2-multilang
[link-travis]: https://travis-ci.org/xz1mefx/yii2-multilang
[link-scrutinizer]: https://scrutinizer-ci.com/g/xz1mefx/yii2-multilang/?branch=master
