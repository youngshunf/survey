<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Roadside */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="roadside-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'rescue_name')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'rescue_phone')->textInput(['maxlength' => 20]) ?>
 
     <?= $form->field($model, 'arrive_time')->widget(DateTimePicker::classname(), [
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
