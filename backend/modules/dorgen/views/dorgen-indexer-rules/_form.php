<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenIndexerRules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dorgen-indexer-rules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dorgen_site_id')->textInput() ?>

    <?= $form->field($model, 'attribute')->dropDownList([ 'title' => 'Title', 'text' => 'Text', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'function')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
