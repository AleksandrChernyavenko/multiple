<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenIndexer */

$this->title = 'Create Dorgen Indexer';
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Indexers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-indexer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
