<?php
namespace xz1mefx\multilang\caching;

use yii\caching\FileCache;

/**
 * @inheritdoc
 */
class MultilangCache extends FileCache
{

    /**
     * @inheritdoc
     */
    public $cachePath = '@vendor/xz1mefx/yii2-multilang/runtime/cache';

}
