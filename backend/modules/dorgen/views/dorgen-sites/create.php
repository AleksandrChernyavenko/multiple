<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenSites */

$this->title = 'Create Dorgen Sites';
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-sites-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
