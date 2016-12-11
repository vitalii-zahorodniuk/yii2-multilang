<?php
namespace xz1mefx\multilang\actions\lang;

use xz1mefx\multilang\models\Lang;
use Yii;
use yii\base\Action;
use yii\bootstrap\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class UpdateAction
 *
 * @property string $theme it can be IndexAction::THEME_BOOTSTRAP or IndexAction::THEME_ADMINLTE
 * @property string $view the view name (if need to override)
 *
 * @package xz1mefx\multilang\actions\lang
 */
class UpdateAction extends Action
{

    const THEME_BOOTSTRAP = 'bootstrap';
    const THEME_ADMINLTE = 'adminlte';

    public $theme = self::THEME_BOOTSTRAP;
    public $view = NULL;

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        if (($model = Lang::findOne($id)) === NULL) {
            throw new NotFoundHttpException(Yii::t('xz1mefx-multilang', 'The requested language does not exist'));
        } else {
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->controller->redirect(['index']);
            } else {
                return $this->controller->render(
                    $this->view ?: "@vendor/xz1mefx/yii2-multilang/views/lang/{$this->theme}/update",
                    [
                        'model' => $model,
                    ]
                );
            }
        }
    }

}
