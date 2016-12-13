<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\i18n\TranslationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend_translation', 'Interface translations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $columns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['class' => 'col-lg-1'],
            'contentOptions' => ['class' => 'text-center col-lg-1'],
        ],
        [
            'attribute' => 'category',
            'headerOptions' => ['class' => 'col-lg-2'],
            'contentOptions' => ['class' => 'text-center col-lg-2'],
        ],
        [
            'attribute' => 'message',
            'headerOptions' => ['class' => 'col-lg-3'],
            'contentOptions' => ['class' => 'col-lg-3'],
        ],
    ];
    foreach ($searchModel->langListArray as $lang) {
        $columns[] = [
            'label' => $lang['name'],
            'attribute' => $lang['url'],
            'content' => function ($model) use ($lang) {
                /* @var $model backend\models\i18n\SourceMessage */
                return $model->getTranslationByLocal($lang['locale']);
            },
        ];
    }
    $columns[] = [
        'class' => 'yii\grid\ActionColumn',
        'headerOptions' => ['class' => 'col-lg-1'],
        'contentOptions' => ['class' => 'text-center col-lg-1'],
        'template' => '{update}',
    ];
    print GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]);
    ?>

</div>
