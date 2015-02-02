<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenIndexer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dorgen-indexer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dorgen_spider_translate_id')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'success' => 'Success', 'error' => 'Error', 'in_progress' => 'In progress', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    <?= $form->field($model, 'error_response')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
