<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\i18n\SourceMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="source-message-form">

    <?php $form = ActiveForm::begin(); ?>

    <strong><?= $model->getAttributeLabel('category') ?>:</strong>
    <div class="well"><?= $model->category ?></div>

    <strong><?= $model->getAttributeLabel('message') ?>:</strong>
    <div class="well"><?= $model->message ?></div>

    <hr>

    <?php foreach ($model->langListArray as $key => $lang): ?>
        <?= $form->field($model, "langs[$key]")->textarea(['rows' => 4])->label(Yii::t('backend_translation', $lang['name'])) ?>
    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend_translation', 'Create') : Yii::t('backend_translation', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
