<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenSites */

$this->title = 'Update Dorgen Sites: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dorgen-sites-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
