<?php
use yii\bootstrap\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel xz1mefx\multilang\models\search\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $canAdd bool */
/* @var $canUpdate bool */
/* @var $canDelete bool */

$this->title = Yii::t('multilang-tools', 'Languages');

$this->params['breadcrumbs'][] = $this->title;

$this->params['title'] = $this->title;

$this->registerCss(<<<CSS
@media (max-width: 425px) {
    .grid-view thead th:nth-child(3),
    .grid-view thead td:nth-child(3),
    .grid-view tbody td:nth-child(3),
    .grid-view thead th:nth-child(4),
    .grid-view thead td:nth-child(4),
    .grid-view tbody td:nth-child(4) {
        display: none;
    }
}

@media (max-width: 375px) {
    .grid-view thead th:nth-child(5),
    .grid-view thead td:nth-child(5),
    .grid-view tbody td:nth-child(5) {
        display: none;
    }

    .default-lang-ico {
        display: inline-block !important;
    }
}
CSS
);
?>

<div class="box box-primary">
    <div class="box-header">
        <?php if ($canAdd): ?>
            <?= Html::a(Yii::t('multilang-tools', 'Add language'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php else: ?>
            &nbsp;
        <?php endif; ?>
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
                        'attribute' => 'name',
                        'content' => function ($model) {
                            /* @var $model \xz1mefx\multilang\models\Language */
                            return $model->name . ($model->default == 1 ? ' ' . Html::icon('ok', [
                                        'class' => 'text-red default-lang-ico',
                                        'style' => 'display: none;',
                                    ]) : '');
                        },
                    ],
                    'url',
                    'locale',
                    [
                        'attribute' => 'default',
                        'filter' => FALSE,
                        'headerOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                        'contentOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                        'content' => function ($model) {
                            /* @var $model \xz1mefx\multilang\models\Language */
                            if ($model->default == 1) {
                                return Html::icon('ok', ['class' => 'text-red']);
                            }
                            return NULL;
                        },
                    ],

                    [
                        'class' => ActionColumn::className(),
                        'visible' => $canUpdate || $canDelete,
                        'headerOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                        'contentOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                        'template' => '{update} {delete}',
                        'visibleButtons' => [
                            'update' => $canUpdate,
                            'delete' => $canDelete,
                        ],
                        // TODO: Add make default button
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
