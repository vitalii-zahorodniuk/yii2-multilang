<?php
namespace xz1mefx\multilang\actions\language;

use xz1mefx\multilang\actions\BaseAction;
use xz1mefx\multilang\models\search\LanguageSearch;
use Yii;

/**
 * Class IndexAction
 *
 * @property string $theme it can be IndexAction::THEME_BOOTSTRAP or IndexAction::THEME_ADMINLTE
 * @property string $view  the view name (if need to override)
 *
 * @property bool   $canAdd
 * @property bool   $canUpdate
 * @property bool   $canDelete
 *
 * @package xz1mefx\multilang\actions\lang
 */
class IndexAction extends BaseAction
{

    public $canAdd = TRUE;
    public $canUpdate = TRUE;
    public $canDelete = TRUE;

    /**
     * @return string
     */
    public function run()
    {
        $searchModel = new LanguageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->controller->render(
            $this->view ?: "@vendor/xz1mefx/yii2-multilang/views/language/{$this->theme}/index",
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,

                'canAdd' => $this->canAdd,
                'canUpdate' => $this->canUpdate,
                'canDelete' => $this->canDelete,
            ]
        );
    }

}
