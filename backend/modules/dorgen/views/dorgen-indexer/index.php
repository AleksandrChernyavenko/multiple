<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dorgen\models\search\DorgenIndexerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dorgen Indexers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-indexer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dorgen Indexer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dorgen_spider_translate_id',
            'status',
            'start_time',
            'end_time',
            // 'error_response:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
