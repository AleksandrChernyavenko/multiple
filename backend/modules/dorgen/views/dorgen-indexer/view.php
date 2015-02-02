<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenIndexer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Indexers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-indexer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'dorgen_spider_translate_id',
            'status',
            'start_time',
            'end_time',
            'error_response:ntext',
        ],
    ]) ?>

</div>
