<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model xz1mefx\multilang\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-body">
        <div class="box-body-overflow">
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'validateOnType' => true]); ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'locale')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?php if (!$model['default']): ?>
                <?= $form->field($model, 'default')->checkbox() ?>
                <p class="text-info" style="margin-top: -15px;">
                    <?= Html::icon('info-sign') . ' ' . Yii::t('multilang-tools', 'If you select this option here, it will be reset everywhere') ?>
                </p>
            <?php endif; ?>

            <div class="form-group">
                <?= Html::submitButton(
                    $model->isNewRecord ? Yii::t('multilang-tools', 'Add language') : Yii::t('multilang-tools', 'Update language'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
