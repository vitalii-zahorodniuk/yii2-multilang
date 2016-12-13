<?php
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model xz1mefx\multilang\models\Lang */

$this->title = Yii::t('multilang-tools', 'Add language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('multilang-tools', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="lang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
