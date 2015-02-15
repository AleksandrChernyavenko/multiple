<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\glossary\models\GlossaryModel */

$this->title = 'Create Glossary Model';
$this->params['breadcrumbs'][] = ['label' => 'Glossary Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="glossary-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
