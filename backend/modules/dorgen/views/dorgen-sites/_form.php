<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenSites */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="dorgen-sites-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'pause' => 'Pause', 'in_progress' => 'In progress', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'host')->textInput(['maxlength' => 255])->label($model->getAttributeLabel('host').\backend\modules\glossary\helpers\Popover::g('dorgenSites.host')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
