<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dorgen\models\search\DorgenCrawlerUrlsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dorgen Crawler Urls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-crawler-urls-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dorgen Crawler Urls', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dorgen_site_id',
            'url:url',
            'status',
            'is_article',
             'start_time',
             'end_time',
             'error_response:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
