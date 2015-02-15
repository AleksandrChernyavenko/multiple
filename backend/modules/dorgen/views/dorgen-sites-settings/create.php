<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenSitesSettingsModel */

$this->title = 'Create Dorgen Sites Settings Model';
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Sites Settings Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-sites-settings-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
