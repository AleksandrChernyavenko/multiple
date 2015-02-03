<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\xss\models\XssSites */

$this->title = 'Create Xss Sites';
$this->params['breadcrumbs'][] = ['label' => 'Xss Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xss-sites-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
