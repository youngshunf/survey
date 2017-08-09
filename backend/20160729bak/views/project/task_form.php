<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use wenyuan\ueditor\Ueditor;
use yii\web\View;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/lrz.bundle.js', ['position'=> View::POS_HEAD]);
$this->registerJsFile('@web/js/PCASClass.js', ['position'=> View::POS_HEAD]);
?>

<div class="row">

    <?php $form = ActiveForm::begin(['id'=>'task-form','options' => ['enctype' => 'multipart/form-data','onsubmit'=>'return check()']]); ?>
 
    <div class="col-md-6">
      <?= $form->field($model, 'type')->dropDownList(['1'=>'调查','3'=>'招募']) ?>
      <?= $form->field($model, 'answer_type')->dropDownList(['1'=>'点任务','2'=>'面任务'])->label('结果约束类型') ?>
      <div id="answerRadius"  class="hide" >
        <?= $form->field($model, 'answer_radius') ?>
      </div>
          <?= $form->field($model, 'radius')->textInput(['maxlength' => 10]) ?>  
          <?= $form->field($model, 'do_radius')->textInput(['maxlength' => 10]) ?>      
          <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map($group, 'group_id', 'group_name'),['prompt'=>'所有人']) ?>
           
    </div>

    <div class="col-md-6">
    <?= $form->field($model, 'do_type')->dropDownList(['1'=>'宅在家','2'=>'四处跑']) ?>
    <?= $form->field($model, 'max_times')->textInput(['maxlength'=>8]) ?>
    <?= $form->field($model, 'price')->textInput(['maxlength' => 5]) ?>
          <?= $form->field($model, 'number')->textInput(['maxlength' => 5]) ?>
          <?= $form->field($model, 'is_show_price')->dropDownList(['1'=>'是','0'=>'否'])?>
     <?= $form->field($model, 'end_time')->widget(DateTimePicker::className(),[
        'options' => ['placeholder' => '请选择任务结束时间'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]); ?>

    </div>

    <div class="col-md-12">
  
        <div class="form-group">
         <label>任务描述</label>
          <?= Ueditor::widget(['id'=>'desc',
                'model'=>$model,
                'attribute'=>'desc',
                'ucontent'=>$model->desc,
                ]);  ?>
        </div>
        
           
    <div class="form-group center" >
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">



function check(){
	  var required=0;
		$('.required').find('input').each(function(){
		    if(!$(this).val()){
		    	required++;
		    }
		});

		if(required!=0){
		    modalMsg('请填写完整再提交');
		    return false;
		}
	  
    showWaiting('正在提交,请稍候...');
    return true;
}

</script>
