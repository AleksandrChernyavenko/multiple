<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenSitesSettingsModel */

$this->title = 'Update Dorgen Sites Settings Model: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Sites Settings Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dorgen-sites-settings-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
