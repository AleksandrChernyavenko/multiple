<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dorgen\models\search\DorgenSpiderTranslateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dorgen Spider Translates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-spider-translate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dorgen Spider Translate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dorgen_crawler_url_id:url',
            'status',
            'date_start',
            'date_end',
            // 'file_name',
            // 'error_response:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
