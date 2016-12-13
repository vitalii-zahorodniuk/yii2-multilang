<?php
namespace xz1mefx\multilang\actions\lang;

use xz1mefx\multilang\actions\BaseAction;
use xz1mefx\multilang\models\Lang;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class DeleteAction
 *
 * @property string $theme it can be IndexAction::THEME_BOOTSTRAP or IndexAction::THEME_ADMINLTE
 * @property string $view the view name (if need to override)
 *
 * @package xz1mefx\multilang\actions\lang
 */
class DeleteAction extends BaseAction
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
            if ($model->default != 0) {
                Yii::$app->session->setFlash('danger', Yii::t('multilang-tools', 'You can\'t delete default language!'));
            } else {
                $model->delete();
                Yii::$app->session->setFlash('success', Yii::t('multilang-tools', 'Language deleted successfully!'));
            }
        }

        return $this->controller->redirect(['index']);
    }

}
