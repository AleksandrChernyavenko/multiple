<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            'site_id',
            'name',
            'type',
            'required',
            // 'value:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
