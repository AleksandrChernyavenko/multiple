<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dorgen\models\search\DorgenCrawlerRulesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dorgen Crawler Rules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-crawler-rules-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dorgen Crawler Rules', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'site',
                'value' => function($model) {
                    /* @var $model backend\modules\dorgen\models\DorgenCrawlerRules */
                    $site = $model->site;
                    return  $site ? $site->displayName : '';

                }
            ],

            'name',
            'type',
            'required:boolean',
            'value:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>

</div>
