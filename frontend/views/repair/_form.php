<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Maintenance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maintenance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'r_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'm_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'r_phone')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'm_time')->widget(DateTimePicker::classname(), [
		    'options' => ['placeholder' => '请选择时间'],
		    'pluginOptions' => [
		        'autoclose'=>true,
		    ]
	])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>