<?php

use yii\grid\GridView;
use yii\helpers\Html;

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
            [
                'attribute'=>'host',
                'label'=>$searchModel->getAttributeLabel('host').\backend\modules\glossary\helpers\Popover::g('dorgenSites.host'),
                'encodeLabel'=>false,
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
