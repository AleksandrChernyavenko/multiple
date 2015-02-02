<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\xss\models\search\XssCookieSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Xss Cookies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xss-cookie-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Xss Cookie', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sites_id',
            'created_at',
            'from_url',
            'from_ip',
//             'user_agent:ntext',
            // 'is_mobile',
             'cookie:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
