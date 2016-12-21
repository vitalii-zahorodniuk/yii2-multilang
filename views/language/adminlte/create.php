<?php

/* @var $this yii\web\View */
/* @var $model xz1mefx\multilang\models\Language */

$this->title = Yii::t('multilang-tools', 'Add language');

$this->params['breadcrumbs'][] = ['label' => Yii::t('multilang-tools', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['title'] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
