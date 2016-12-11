<?php
namespace xz1mefx\multilang\actions\lang;

use xz1mefx\multilang\models\search\LangSearch;
use Yii;
use yii\base\Action;

/**
 * Class IndexAction
 *
 * @property string $theme it can be IndexAction::THEME_BOOTSTRAP or IndexAction::THEME_ADMINLTE
 * @property string $view the view name (if need to override)
 *
 * @property bool $canAdd
 * @property bool $canUpdate
 * @property bool $canDelete
 *
 * @package xz1mefx\multilang\actions\lang
 */
class IndexAction extends Action
{

    const THEME_BOOTSTRAP = 'bootstrap';
    const THEME_ADMINLTE = 'adminlte';

    public $theme = self::THEME_BOOTSTRAP;
    public $view = NULL;

    public $canAdd = true;
    public $canUpdate = true;
    public $canDelete = true;

    /**
     * @return string
     */
    public function run()
    {
        $searchModel = new LangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->controller->render(
            $this->view ?: "@vendor/xz1mefx/yii2-multilang/views/lang/{$this->theme}/index",
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
