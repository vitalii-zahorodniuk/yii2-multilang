<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \xz1mefx\multilang\models\SourceMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="source-message-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => TRUE, 'validateOnType' => TRUE]); ?>

    <strong><?= $model->getAttributeLabel('category') ?>:</strong>
    <div class="well"><?= $model->category ?></div>

    <strong><?= $model->getAttributeLabel('message') ?>:</strong>
    <div class="well"><?= Yii::$app->formatter->asNtext($model->message) ?></div>

    <hr>

    <?php foreach (Yii::$app->lang->getLangList() as $key => $lang): ?>
        <?= $form->field($model, "langs[$key]")->textarea(['rows' => 4])->label(Yii::t('multilang-tools', $lang['name'])) ?>
    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('multilang-tools', 'Create') : Yii::t('multilang-tools', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
