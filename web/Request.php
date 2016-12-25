<?php
namespace xz1mefx\multilang\web;

use Yii;
use yii\base\InvalidConfigException;
use xz1mefx\base\helpers\Url;

/**
 * Class Request
 * @package xz1mefx\multilang\web
 */
class Request extends \yii\web\Request
{

    /**
     * Resolves the path info part of the currently requested URL.
     * A path info refers to the part that is after the entry script and before the question mark (query string).
     * The starting slashes are both removed (ending slashes will be kept).
     * @return string part of the request URL that is after the entry script and before the question mark.
     * Note, the returned path info is decoded.
     * @throws InvalidConfigException if the path info cannot be determined due to unexpected server configuration
     */
    public function resolvePathInfo()
    {
        $pathInfo = $this->requestHandleLang($this->getUrl());

        if (($pos = strpos($pathInfo, '?')) !== FALSE) {
            $pathInfo = substr($pathInfo, 0, $pos);
        }

        $pathInfo = urldecode($pathInfo);

        // try to encode in UTF8 if not so
        // http://w3.org/International/questions/qa-forms-utf-8.html
        if (!preg_match('%^(?:
            [\x09\x0A\x0D\x20-\x7E]              # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
            | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
            )*$%xs', $pathInfo)
        ) {
            $pathInfo = utf8_encode($pathInfo);
        }

        $scriptUrl = $this->getScriptUrl();
        $baseUrl = $this->getBaseUrl();
        if (strpos($pathInfo, $scriptUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($scriptUrl));
        } elseif ($baseUrl === '' || strpos($pathInfo, $baseUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($baseUrl));
        } elseif (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], $scriptUrl) === 0) {
            $pathInfo = substr($_SERVER['PHP_SELF'], strlen($scriptUrl));
        } else {
            throw new InvalidConfigException('Unable to determine the path info of the current request.');
        }

        if ($pathInfo[0] === '/') {
            $pathInfo = substr($pathInfo, 1);
        }

        return (string)$pathInfo;
    }

    /**
     * Handle language in URL.
     *
     * @param string $url URL
     *
     * @return string URL
     */
    private function requestHandleLang($url)
    {
        if (Yii::$app->lang->enabled()) {
            $dDLang = Yii::$app->lang->tryGetUrlLang($url);

            if (empty($dDLang)) {
                $dDLang = Yii::$app->lang->tryDetectDDLang();
                Yii::$app->getResponse()->redirect(Url::home(TRUE) . $dDLang . Url::removeUrlSegment($url, Url::home()), 302);
            }

            Yii::$app->lang->setIsoDDLang($dDLang);

            return Url::removeUrlSegment($url, $dDLang); // return URL without language code
        }

        return $url;
    }
}
