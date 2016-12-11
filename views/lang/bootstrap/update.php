<?php
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model xz1mefx\multilang\models\Lang */

$this->title = Yii::t('xz1mefx-multilang', 'Update language: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('xz1mefx-multilang', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="lang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
