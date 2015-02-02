<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dorgen\models\search\DorgenSitesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dorgen Sites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-sites-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dorgen Sites', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'url:url',
            'description',
            'status',
            // 'host',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
