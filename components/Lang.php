<?php
namespace xz1mefx\multilang\components;

use xz1mefx\base\helpers\Url;
use xz1mefx\multilang\models\Language as LangModel;
use Yii;
use yii\base\Component;
use yii\web\Cookie;

/**
 * Class Language
 *
 * @package xz1mefx\multilang\components
 */
class Lang extends Component
{

    /**
     * Language array for DB
     *
     * @var array
     */
    private $_langsList;

    /**
     * Double digit language code
     *
     * @var string
     */
    private $_dDLang;

    /**
     * Default language data array
     *
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
     * Get double digit language
     * @return string
     */
    public function getDDLang()
    {
        return $this->_dDLang;
    }

    /**
     * Get double digit language
     * @return string
     */
    public function getId()
    {
        return $this->_langsList[$this->_dDLang]['id'];
    }

    /**
     * Try to get double-digit language code from url
     *
     * @param string $url URL
     *
     * @return string Double-digit language code
     */
    public function tryGetUrlLang($url)
    {
        $dDLang = explode(
            '/',
            trim(
                Url::removeUrlSegment($url, Url::home()), // remove url home ()
                '/'
            )
        )[0];
        return $this->checkDDLang($dDLang) ? $dDLang : NULL;
    }

    /**
     * Check language double-digit code
     *
     * @param string $dDLang Double-digit language code
     *
     * @return boolean
     */
    private function checkDDLang($dDLang)
    {
        if (empty($dDLang)) {
            return FALSE;
        }
        return array_key_exists($dDLang, $this->_langsList);
    }

    /**
     * Try detect double-digit language code
     *
     * @return string Double-digit language code
     */
    public function tryDetectDDLang()
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
     *
     * @param string $dDLang Double-digit language code
     */
    public function setIsoDDLang($dDLang)
    {
        $this->_dDLang = $dDLang;
        Yii::$app->language = $this->_langsList[$dDLang]['locale'];
        Yii::$app->session->set('lang', $dDLang);
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'lang',
            'value' => $dDLang,
            'expire' => time() + 60 * 60 * 24 * 90, // 3 month
        ]));
    }

    /**
     * Determines it necessary to work with the language
     *
     * @return bool
     */
    public function enabled()
    {
        return count($this->_langsList) > 1;
    }

    /**
     * Get current URL with language
     *
     * @param string  $dDLang Double-digit language code
     * @param boolean $scheme
     *
     * @return string URL
     */
    public function getCurrentUrlWithLang($dDLang, $scheme = FALSE)
    {
        $urlToWithoutBase = Url::removeUrlSegment(Url::to(), Url::base());
        $urlToWithoutCurrentLanguage = Url::removeUrlSegment($urlToWithoutBase, $this->_dDLang);
        return Url::home($scheme) . $dDLang . $urlToWithoutCurrentLanguage;
    }

}
