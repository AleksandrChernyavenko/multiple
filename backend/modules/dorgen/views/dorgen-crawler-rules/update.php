<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenCrawlerRules */

$this->title = 'Update Dorgen Crawler Rules: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Crawler Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dorgen-crawler-rules-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
