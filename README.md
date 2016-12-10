Multilanguage tools package for yii2
=======================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

1. either run

```
php composer.phar require --prefer-dist xz1mefx/yii2-multilang "dev-master"
```

2. execute migration:

```
php yii migrate --migrationPath=@vendor/xz1mefx/yii2-multilang/migrations --interactive=0
```

3. add components to common/main config file (or change components classes):
```
'urlManager' => [
    'class' => \xz1mefx\multilang\web\UrlManager::className(),
],
'request' => [
    'class' => \xz1mefx\multilang\web\Request::className(),
],
'lang' => [
    'class' => \xz1mefx\multilang\components\Lang::className(),
],
```

4. if you use `iiifx-production/yii2-autocomplete-helper` you need to run:
```
composer autocomplete
```

5. override components in console/main config file:
```
'request' => [ // override common config
    'class' => 'yii\console\Request',
],
'urlManager' => [], // override common config
'i18n' => [], // override common config
```


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
