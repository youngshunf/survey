<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    </div>
 
    <div class="col-md-6">
      <?= $form->field($model, 'type')->dropDownList(['0'=>'调查','1'=>'评论','2'=>'招募','3'=>'体验']) ?>
          <?= $form->field($model, 'radius')->textInput() ?>     
          <?= $form->field($model, 'group_id')->dropDownList(['0'=>'所有人']) ?>
           <?= $form->field($model, 'price')->textInput() ?>
          <?= $form->field($model, 'number')->textInput() ?>
    </div>

    <div class="col-md-6">
    <?= $form->field($model, 'do_type')->dropDownList(['0'=>'宅在家','1'=>'四处跑']) ?>
    <?= $form->field($model, 'province')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'district')->textInput(['maxlength' => 255]) ?>

   

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>
         <?= $form->field($model, 'end_time')->widget(DateTimePicker::className(),[
        'options' => ['placeholder' => '请选择任务结束时间'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]); ?>

    </div>

    <div class="col-md-12">
    <div class="form-group center" >
        <?= Html::submitButton($model->isNewRecord ? '提交' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
