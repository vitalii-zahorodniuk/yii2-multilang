<?php
use yii\bootstrap\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel xz1mefx\multilang\models\search\LangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $canAdd bool */
/* @var $canUpdate bool */
/* @var $canDelete bool */

$this->title = Yii::t('multilang-tools', 'Languages');
$this->params['breadcrumbs'][] = $this->title;

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

<div class="lang-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($canAdd): ?>
        <p>
            <?= Html::a(Yii::t('multilang-tools', 'Add language'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                'contentOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
            ],

            'name',
            'url',
            'locale',
            [
                'attribute' => 'default',
                'filter' => FALSE,
                'headerOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                'contentOptions' => ['class' => 'text-center col-xs-1 col-sm-1'],
                'content' => function ($model) {
                    /* @var $model \xz1mefx\multilang\models\Lang */
                    if ($model->default == 1) {
                        return Html::icon('ok');
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
