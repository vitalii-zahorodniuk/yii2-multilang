<?php
use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var $model \xz1mefx\multilang\models\SourceMessage */

$this->title = Yii::t('multilang-tools', 'Update translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('multilang-tools', 'Interface translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="source-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
