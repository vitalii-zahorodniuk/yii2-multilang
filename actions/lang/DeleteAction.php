<?php
namespace xz1mefx\multilang\actions\lang;

use xz1mefx\multilang\models\Lang;
use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;

/**
 * Class DeleteAction
 *
 * @property string $theme it can be IndexAction::THEME_BOOTSTRAP or IndexAction::THEME_ADMINLTE
 * @property string $view the view name (if need to override)
 *
 * @package xz1mefx\multilang\actions\lang
 */
class DeleteAction extends Action
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
            if ($model->default != 0) {
                Yii::$app->session->setFlash('danger', Yii::t('xz1mefx-multilang', 'You can\'t delete default language!'));
            } else {
                $model->delete();
                Yii::$app->session->setFlash('success', Yii::t('xz1mefx-multilang', 'Language deleted successfully!'));
            }
        }

        return $this->controller->redirect(['index']);
    }

}
