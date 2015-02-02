<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenSpiderTranslate */

$this->title = 'Create Dorgen Spider Translate';
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Spider Translates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-spider-translate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
