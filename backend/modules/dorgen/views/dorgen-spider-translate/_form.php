<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenSpiderTranslate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dorgen-spider-translate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'dorgen_crawler_url_id')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'success' => 'Success', 'error' => 'Error', 'in_work' => 'In work', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'date_start')->textInput() ?>

    <?= $form->field($model, 'date_end')->textInput() ?>

    <?= $form->field($model, 'file_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'error_response')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
