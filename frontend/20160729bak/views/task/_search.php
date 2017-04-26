<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\SearchTask */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.task-search input{
	width:auto;
}
.form-group{
	float:left;
}
</style>
<div class="clear"></div>
<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?php  echo $form->field($model, 'province') ?>

    <?php  echo $form->field($model, 'city') ?>

    <?php  echo $form->field($model, 'district') ?>
    
     <?php  echo $form->field($model, 'address') ?>
    
   <?= $form->field($model, 'search_start_time')->widget(DateTimePicker::className(),[
        'options' => ['placeholder' => '请选择开始时间'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ])->label('开始时间'); ?>
    
     <?= $form->field($model, 'search_end_time')->widget(DateTimePicker::className(),[
        'options' => ['placeholder' => '请选择结束时间'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ])->label('结束时间'); ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'end_time') ?>

   

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'radius') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'total_price') ?>

    <?php // echo $form->field($model, 'group_id') ?>
<div class="clear"></div>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default','id'=>'reset']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="clear"></div>

<script>
$('#reset').click(function(){
	
  $('.task-search').find('input').attr('value','');
});
</script>