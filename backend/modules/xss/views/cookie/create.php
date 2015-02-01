<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\XssCookie */

$this->title = 'Create Xss Cookie';
$this->params['breadcrumbs'][] = ['label' => 'Xss Cookies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xss-cookie-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
