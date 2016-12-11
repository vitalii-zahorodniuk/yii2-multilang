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

$this->title = Yii::t('xz1mefx-multilang', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="lang-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($canAdd): ?>
        <p>
            <?= Html::a(Yii::t('xz1mefx-multilang', 'Add language'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'url',
            'local',
            [
                'attribute' => 'default',
                'filter' => false,
                'headerOptions' => ['class' => 'text-center col-lg-1'],
                'contentOptions' => ['class' => 'text-center col-lg-1'],
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
                'headerOptions' => ['class' => 'text-center col-lg-1'],
                'contentOptions' => ['class' => 'text-center col-lg-1'],
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
