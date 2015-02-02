<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenSpiderTranslate */

$this->title = 'Update Dorgen Spider Translate: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Spider Translates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dorgen-spider-translate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
