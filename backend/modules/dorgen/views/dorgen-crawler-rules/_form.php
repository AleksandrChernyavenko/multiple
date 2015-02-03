<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenCrawlerRules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dorgen-crawler-rules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'site_id')->widget(\common\widgets\Select2Load::className(),[
        'pluginOptions' => [
            'ajax' => [
                'url' => \yii\helpers\Url::to(['/dorgen/dorgen-sites/load']),
            ],
        ],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'url_regex' => 'Url regex', 'html_regex' => 'Html regex', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'required')->textInput() ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
