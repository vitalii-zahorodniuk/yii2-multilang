<?php
namespace xz1mefx\multilang\actions\language;

use xz1mefx\multilang\actions\BaseAction;
use xz1mefx\multilang\models\Lang;
use Yii;
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
class UpdateAction extends BaseAction
{
    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        if (($model = Lang::findOne($id)) === NULL) {
            throw new NotFoundHttpException(Yii::t('multilang-tools', 'The requested language does not exist'));
        } else {
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->controller->redirect(['index']);
            } else {
                return $this->controller->render(
                    $this->view ?: "@vendor/xz1mefx/yii2-multilang/views/language/{$this->theme}/update",
                    [
                        'model' => $model,
                    ]
                );
            }
        }
    }

}
