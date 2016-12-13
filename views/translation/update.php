<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\i18n\SourceMessage */
$this->title = Yii::t('backend_translation', 'Update translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_translation', 'Interface translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend_translation', 'Update');
?>
<div class="source-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
