<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model xz1mefx\multilang\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lang-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'validateOnType' => true]); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'local')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if (!$model['default']): ?>
        <?= $form->field($model, 'default')->checkbox() ?>
        <p class="text-info" style="margin-top: -15px;">
            <?= Html::icon('info-sign') . ' ' . Yii::t('xz1mefx-multilang', 'If you select this option here, it will be reset everywhere') ?>
        </p>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('xz1mefx-multilang', 'Add language') : Yii::t('xz1mefx-multilang', 'Update language'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
