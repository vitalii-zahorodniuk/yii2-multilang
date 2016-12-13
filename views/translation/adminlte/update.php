<?php

/* @var $this \yii\web\View */
/* @var $model \xz1mefx\multilang\models\SourceMessage */

$this->title = Yii::t('multilang-tools', 'Update translation');

$this->params['breadcrumbs'][] = ['label' => Yii::t('multilang-tools', 'Interface translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['title'] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

