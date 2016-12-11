<?php

/* @var $this yii\web\View */
/* @var $model xz1mefx\multilang\models\Lang */

$this->title = Yii::t('xz1mefx-multilang', 'Update language: ') . $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('xz1mefx-multilang', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['title'] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
