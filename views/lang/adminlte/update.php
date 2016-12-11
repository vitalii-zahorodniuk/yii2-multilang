<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model xz1mefx\multilang\models\Lang */

$this->title = Yii::t('xz1mefx-multilang', 'Update {modelClass}: ', [
        'modelClass' => 'Lang',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('xz1mefx-multilang', 'Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('xz1mefx-multilang', 'Update');
?>
<div class="lang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
