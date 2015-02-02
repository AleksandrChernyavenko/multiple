<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenCrawlerUrls */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dorgen-crawler-urls-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dorgen_site_id')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'new' => 'New', 'success' => 'Success', 'error' => 'Error', 'in_work' => 'In work', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_article')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    <?= $form->field($model, 'error_response')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
