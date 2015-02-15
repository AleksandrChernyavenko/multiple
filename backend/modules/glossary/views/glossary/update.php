<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\glossary\models\GlossaryModel */

$this->title = 'Update Glossary Model: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Glossary Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="glossary-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
