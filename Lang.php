<?php

namespace common\components;

use common\models\lang\Lang as LangModel;
use Yii;
use yii\helpers\Url;

class Lang extends \yii\base\Component
{

    /**
     * Language array for DB
     * @var array
     */
    private $_langsList;

    /**
     * Double digit language code
     * @var string
     */
    private $_dDLang;

    /**
     * Default language data array
     * @var array
     */
    private $_defaultLang;

    /**
     * Init component
     */
    public function init()
    {
        $this->_langsList = LangModel::getLangListArray();
        $this->_defaultLang = LangModel::getDefaultLang();
        parent::init();
    }

    /**
     * Get language list
     * @return array
     */
    public function getLangList()
    {
        return $this->_langsList;
    }

    /**
     * Handle language in URL.
     * (only for handle $pathInfo in \yii\web\Request::resolvePathInfo())
     * @param string $url URL
     * @return string URL
     */
    public function requestHandleLang($url)
    {
        if ($this->enabled()) {
            $dDLang = $this->tryGetUrlLang($url);

            if (empty($dDLang)) {
                $dDLang = $this->tryDetectDDLang();
                Yii::$app->getResponse()->redirect(Url::home(true) . $dDLang . $this->removeUrlSegment($url, Url::home()), 302);
            }

            $this->setLang($dDLang);

            return $this->removeUrlSegment($url, $dDLang); // return URL without language code
        }

        return $url;
    }

    /**
     * Determines it necessary to work with the language
     * @return bool
     */
    public function enabled()
    {
        return count($this->_langsList) > 1;
    }

    /**
     * Try to get double-digit language code from url
     * @param string $url URL
     * @return string Double-digit language code
     */
    private function tryGetUrlLang($url)
    {
        $dDLang = explode('/', trim($this->removeUrlSegment($url, Url::home()), '/'))[0];
        return $this->checkDDLang($dDLang) ? $dDLang : NULL;
    }

    /**
     * Try to remove URL segment
     * @param string $url Subject URL
     * @param string $segment Search segment
     * @param string $replacement Replacement string
     * @return string Results URL
     */
    private function removeUrlSegment($url, $segment, $replacement = '/')
    {
        $preparedSegment = trim($segment, '/');
        if (empty($preparedSegment)) {
            return $url;
        }
        preg_match('/^([^?]+?)(\?.+?)?$/', $url, $matches); // get url and get apart
        return preg_replace('/\/?' . $preparedSegment . '\/?/i', $replacement, (isset($matches[1]) ? $matches[1] : '')) . (isset($matches[2]) ? $matches[2] : '');
    }

    /**
     * Check language double-digit code
     * @param string $dDLang Double-digit language code
     * @return boolean
     */
    private function checkDDLang($dDLang)
    {
        if (empty($dDLang)) {
            return false;
        }
        return array_key_exists($dDLang, $this->_langsList);
    }

    /**
     * Try detect double-digit language code
     * @return string Double-digit language code
     */
    private function tryDetectDDLang()
    {
        // try to get lang from cookies
        $dDLang = Yii::$app->request->cookies->getValue('lang');
        if ($this->checkDDLang($dDLang)) {
            return $dDLang;
        }
        // try to get lang from session
        $dDLang = Yii::$app->session->get('lang');
        if ($this->checkDDLang($dDLang)) {
            return $dDLang;
        }
        // try to get lang from browser
        if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $dDLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); // first priority lang
            if ($this->checkDDLang($dDLang)) {
                return $dDLang;
            }
        }
        // get default lang
        return $this->_defaultLang['url'];
    }

    /**
     * Set application language
     * @param string $dDLang Double-digit language code
     */
    private function setLang($dDLang)
    {
        $this->_dDLang = $dDLang;
        Yii::$app->language = $this->_langsList[$dDLang]['local'];
        Yii::$app->session->set('lang', $dDLang);
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'lang',
            'value' => $dDLang,
            'expire' => time() + 60 * 60 * 24 * 90, // 3 month
        ]));
    }

    /**
     * Create URL with language.
     * (only for handle \yii\web\UrlManager::createUrl())
     * @param type $url
     * @return type
     */
    public function urlManagerHandleCreatedUrl($url)
    {
        if ($this->enabled()) {
            return Url::home() . $this->_dDLang . $this->removeUrlSegment($url, Url::home());
        }
        return $url;
    }

    /**
     * Get current URL with language
     * @param string $dDLang Double-digit language code
     * @return string URL
     */
    public function getCurrentUrlWithLang($dDLang, $scheme = false)
    {
        return Url::home($scheme) . $dDLang . $this->removeUrlSegment(Url::to(), $this->_dDLang);
    }

}
