<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenIndexer */

$this->title = 'Update Dorgen Indexer: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Indexers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dorgen-indexer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
