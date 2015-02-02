<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenIndexerRules */

$this->title = 'Update Dorgen Indexer Rules: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Indexer Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dorgen-indexer-rules-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
