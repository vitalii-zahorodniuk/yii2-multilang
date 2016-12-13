<?php
namespace xz1mefx\multilang\actions\translation;

use xz1mefx\multilang\actions\BaseAction;
use xz1mefx\multilang\models\search\TranslationSearch;
use Yii;

/**
 * Class IndexAction
 *
 * @property string $theme it can be IndexAction::THEME_BOOTSTRAP or IndexAction::THEME_ADMINLTE
 * @property string $view the view name (if need to override)
 *
 * @property bool $canUpdate
 *
 * @package xz1mefx\multilang\actions\lang
 */
class IndexAction extends BaseAction
{

    public $canUpdate = true;

    /**
     * @return string
     */
    public function run()
    {
        $searchModel = new TranslationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->controller->render(
            $this->view ?: "@vendor/xz1mefx/yii2-multilang/views/translation/{$this->theme}/index",
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,

                'canUpdate' => $this->canUpdate,
            ]
        );
    }

}
