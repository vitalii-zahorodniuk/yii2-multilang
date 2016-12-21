<?php
namespace xz1mefx\multilang\web;

use Yii;

class UrlManager extends \yii\web\UrlManager
{
    /**
     * Creates a URL using the given route and query parameters.
     *
     * You may specify the route as a string, e.g., `site/index`. You may also use an array
     * if you want to specify additional query parameters for the URL being created. The
     * array format must be:
     *
     * ```php
     * // generates: /index.php?r=site/index&param1=value1&param2=value2
     * ['site/index', 'param1' => 'value1', 'param2' => 'value2']
     * ```
     *
     * If you want to create a URL with an anchor, you can use the array format with a `#` parameter.
     * For example,
     *
     * ```php
     * // generates: /index.php?r=site/index&param1=value1#name
     * ['site/index', 'param1' => 'value1', '#' => 'name']
     * ```
     *
     * The URL created is a relative one. Use [[createAbsoluteUrl()]] to create an absolute URL.
     *
     * Note that unlike [[\yii\helpers\Url::toRoute()]], this method always treats the given route
     * as an absolute route.
     *
     * @param string|array $params use a string to represent a route (e.g. `site/index`),
     *                             or an array to represent a route with query parameters (e.g. `['site/index',
     *                             'param1' => 'value1']`).
     *
     * @return string the created URL
     */
    public function createUrl($params)
    {
        return Yii::$app->lang->urlManagerHandleCreatedUrl(parent::createUrl($params)); // create URL with language code
    }

}
