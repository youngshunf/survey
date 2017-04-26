<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GroupUser;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '修改分组-'.$model->group_name;
$this->params['breadcrumbs'][] = ['label' => '用户分组', 'url' => ['group']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
        修改分组-<?= $model->group_name?>
    </div>
</div>
    <div class="box-body">
        <?php $form = ActiveForm::begin([
                  
                   'options'=>['onsubmit'=>'return check()']
                ]); ?>

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => 64]) ?>
      <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>

           
<script>
        
 function check(){
	 

	   if(!$('#group-group_name').val()){
		    modalMsg("请填写分组名");
		    return false;
	   }

	   showWaiting("正在提交,请稍候...");
	   return true;
 }
</script>