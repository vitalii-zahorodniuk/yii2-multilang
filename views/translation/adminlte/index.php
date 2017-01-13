<?php
use xz1mefx\adminlte\helpers\Html;
use xz1mefx\multilang\models\SourceMessage;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel \xz1mefx\multilang\models\search\TranslationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $canUpdate bool */

$this->title = Yii::t('multilang-tools', 'Interface translations');

$this->params['breadcrumbs'][] = $this->title;

$this->params['title'] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header">
        &nbsp;
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <?= Html::icon('minus', ['prefix' => 'fa fa-']) ?>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="box-body-overflow">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                        'contentOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                    ],

                    [
                        'attribute' => 'category',
                        'filter' => SourceMessage::getCategoriesDrDownList(),
                    ],
                    [
                        'attribute' => 'message',
                        'format' => 'text',
                    ],
                    [
                        'label' => Yii::t('multilang-tools', 'Translation ({language})', ['language' => Yii::$app->language]),
                        'attribute' => 'translate',
                        'content' => function ($model) {
                            /* @var $model \xz1mefx\multilang\models\SourceMessage */
                            return Yii::$app->formatter->asNtext($model->getTranslationByLocal(Yii::$app->language));
                        },
                    ],

                    [
                        'class' => ActionColumn::className(),
                        'visible' => $canUpdate,
                        'headerOptions' => ['class' => 'text-center col-lg-1 col-sm-1'],
                        'contentOptions' => ['class' => 'text-center col-lg-1 col-sm-1'],
                        'template' => '{update}',
                        'visibleButtons' => [
                            'update' => $canUpdate,
                        ],
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
