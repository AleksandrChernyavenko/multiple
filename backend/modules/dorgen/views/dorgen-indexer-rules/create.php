<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenIndexerRules */

$this->title = 'Create Dorgen Indexer Rules';
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Indexer Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-indexer-rules-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
