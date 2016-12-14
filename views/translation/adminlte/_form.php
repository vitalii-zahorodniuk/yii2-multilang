<?php
use xz1mefx\adminlte\helpers\Html;
use xz1mefx\adminlte\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \xz1mefx\multilang\models\SourceMessage */
/* @var $form ActiveForm */
?>

<div class="box box-primary">
    <div class="box-body">
        <div class="box-body-overflow">
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'validateOnType' => true]); ?>

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
    </div>
</div>
