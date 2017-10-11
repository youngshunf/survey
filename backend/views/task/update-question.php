<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title ='修改问题:'. $model->name;
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= $model->name?> </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

      <form action="<?=Url::to(['update-question-do'])?>" method="post" id="option-form" onsubmit="return check()">
           <input type="hidden" name="task_guid" value="<?= $model->task_guid?>">
             <input type="hidden" name="question_guid" value="<?= $model->question_guid?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
          
            <div class="form-group">
                <label class="label-control">问题描述</label>
               <input rows="3"  name="name" id="title" class="form-control" value="<?= $model->name?>">
            </div>
            <div class="form-group">
              <input type="checkbox" name="required"  value="1"  <?php if ($model->required==1) echo "checked='checked'";?>>  <label class="label-control">是否必答题</label>
            </div>
            <div class="form-group">
                <label class="label-control">问题类型</label>
                <select name="type"  id="type" class="form-control">
               <option value="0"  <?php if($model->type==0) echo "selected='selected'"?>>单选题</option>
               <option value="1" <?php if($model->type==1) echo "selected='selected'"?>>多选题</option>
               <option value="2" <?php if($model->type==2) echo "selected='selected'"?>>文本题</option>
               <option value="3" <?php if($model->type==3) echo "selected='selected'"?>>图片题</option>
               <option value="4" <?php if($model->type==4) echo "selected='selected'"?>>语音题</option>
               <option value="5" <?php if($model->type==5) echo "selected='selected'"?>>二维码题</option>
               <option value="6" <?php if($model->type==6) echo "selected='selected'"?>>定位题</option>
               <option value="7" <?php if($model->type==7) echo "selected='selected'"?>>数值题</option>
               </select>
            </div>
            
          
            <div id="optArr-container-single"  class="<?php if($model->type!=0) echo 'hide'?>">
            <div id="optArr">
            <?php 
            $i=1;
            if($model->type==0){
                $i=0;
                $options=json_decode($model->options,true);
            foreach ($options as $k=>$v){
                $i++;
                ?>
                <div>
            <div class="input-group">
                 <span class="input-group-addon">选项<?= $k+1?></span>
                 <input type="text" class="form-control" name="optArr[]"  value="<?= $v['opt']?>">
                 <span class="input-group-addon">跳转到</span>
                 <input type="number" class="form-control" name="link[]"  value="<?= @$v['link']?>" placeholder="题目编号">  
                   <span class="input-group-addon">关联引用</span>
                    <input type="number" class="form-control" name="refer[]"  value=<?= @$v['refer']?>  placeholder="题目编号">
              
                 <span class="input-group-addon btn btn-danger  remove">删除</span>
              </div>
               <div>
               <input type="hidden"  name="open[]"   value="<?= @$v['open']?>">
                <input type="checkbox"  name="opencheck"  value="1"   <?php if (!empty($v['open'])&&$v['open']==1) echo "checked='checked' "?>>
                <label >开放选项</label>
             </div>
             </div>
            <?php }?>
            <?php }else{?>
            <div>
            <div class="input-group">
                 <span class="input-group-addon">选项1</span>
                 <input type="text" class="form-control" name="optArr[]"  >
                 <span class="input-group-addon">跳转到</span>
                 <input type="number" class="form-control" name="link[]"   placeholder="题目编号">        
                 <span class="input-group-addon">关联引用</span>
                    <input type="number" class="form-control" name="refer[]"    placeholder="题目编号">
              
              </div>
               <div>
               <input type="hidden"  name="open[]"   value="0">
                <input type="checkbox"  name="opencheck"  value="1"  >
                <label >开放选项</label>
             </div>
             </div>
            <?php }?>
            <input type="hidden" id="singleOptNum" value="<?= $i?>">
              </div>
               <p class="pull-right"><a id="addOpt" href="javascript:;"><span class="glyphicon glyphicon-plus " style="color: red;font-size:26px"> </span></a></p>
                <p class="clear"></p>
                </div>
            
            
            
             <div id="optArr-container-multi"   class="<?php if($model->type!=1) echo 'hide'?>">
            <div id="optArr-multi">
            <?php
            $i=1;
             if($model->type==1){
                 $i=0;
             $options=json_decode($model->options,true);
            foreach ($options as $k=>$v){
                $i++;
            ?>
                <div class="input-group">
                    <span class="input-group-addon">选项<?= $k+1?></span>             
                 <input type="text" name="optArrMulti[]" class="form-control"  value="<?= $v?>">                                  
                <span class="input-group-addon btn btn-danger remove-multi">删除</span>       
                </div>
                <?php }?>
                <?php }else{?>
                <div class="input-group">
                  <span class="input-group-addon">选项1</span>             
                 <input type="text" name="optArrMulti[]" class="form-control"  >        
                  <span class="input-group-addon btn btn-danger remove-multi">删除</span>                          
                </div>
                <?php }?>
            </div>
            <input type="hidden" id="multiOptNum" value="<?= $i?>">
               <p class="pull-right"><a id="addOpt-multi" href="javascript:;"><span class="glyphicon glyphicon-plus " style="color: red;font-size:26px"> </span></a></p>
                <p class="clear"></p>
                </div>
                
                
                
                <div id="qrcode-container"  class="<?php if($model->type!=5) echo 'hide'?>" >
                <div class="form-group">
                    <label class="label-control">二维码验证值</label>                
                    <input type="text" name="qrcode-value" class="form-control"  id="qrcode-value"  value="<?= $model->qrcode_value?>">                                  
                </div>
                </div>
              
                
                <div id="imgnum-container"  class="<?php if($model->type!=3) echo 'hide'?>">
           
                <div class="form-group">
                    <label class="label-control">上传图片数量</label>                
                    <input type="number" name="imgnum" class="form-control" id="imgnum" value="<?= $model->max_photo?>">                                  
                </div>
                <div class="form-group">
                    <label class="label-control">拍照类型</label>       
                    <select name="phototype" class="form-control">
                    <option value="1">仅拍照</option>
                    <option value="2">拍照和相册选择</option>
                    </select>         
                </div>
                </div>
                
                
               <div id="number-container"  class="<?php if($model->type!=7) echo 'hide'?>">
            <div id="numArr">
            <div class="input-group">
                            <span class="input-group-addon">最小值</span>
                 <input type="number" class="form-control" name="minnum"  placeholder="请输入最小值">      
                 <span class="input-group-addon">最大值</span>
                 <input type="text" class="form-control"  name="maxnum"  placeholder="请输入最大值">
   
              </div>
            </div>
                <p class="clear"></p>
                </div>
                <p class="center"><button type="submit" class="btn btn-info">提交</button>
               <a class="btn btn-danger" href="<?= Url::to(yii::$app->request->referrer) ?>">返回</a>
                </p>
            </form>
    </div>
    </div>
    
    
<script>
$('.option').click(function(){
    $("#addoption").modal('show');
});
$('.template').click(function(){
    $("#addTemplate").modal('show');
});
var i=parseInt($('#multiOptNum').val());
$("#addOpt-multi").click(function(){
	i++;
    var innerHtml='<div class="input-group">\
        <span class="input-group-addon">选项'+i+'</span><input type="text" name="optArrMulti[]" class="form-control">\
        <span class="input-group-addon btn btn-danger remove-multi">删除</span>\
        </div>';
    $("#optArr-multi").append(innerHtml);
});
 var j=parseInt($('#singleOptNum').val());
$("#addOpt").click(function(){
	j++;
    var innerHtml='<div><div class="input-group">\
        <span class="input-group-addon">选项'+j+'</span>\
        <input type="text" class="form-control" name="optArr[]" >\
        <span class="input-group-addon">跳转到</span>\
        <input type="number" class="form-control" name="link[]"  placeholder="请输入题目编号">\
        <span class="input-group-addon">关联引用</span>\
        <input type="number" class="form-control" name="refer[]"  placeholder="题目编号">\
        <span class="input-group-addon btn btn-danger  remove">删除</span></div>\
         <div><input type="hidden"  name="open[]"   value="0">\
        <input type="checkbox"  name="opencheck"  value="1"  >\
       <label >开放选项</label></div></div> ';
    $("#optArr").append(innerHtml);
});

$(document).on('click','.remove',function(){
    $(this).parent().parent().remove();
});
$(document).on('click','.remove-multi',function(){
    $(this).parent().remove();
});

$(document).on('change','input[name=opencheck]',function(){
    var that=$(this);
    if(that.is(':checked')){
        that.siblings('input').val(1);
    }else{
    	that.siblings('input').val(0);
    }
});

$("#type").click(function(){
   var type=$(this).val();
   if(type==0){
	    $("#optArr-container-single").removeClass('hide');
	    $("#optArr-container-multi").addClass('hide');
	    $("#qrcode-container").addClass('hide');
	    $("#imgnum-container").addClass('hide');
	    $("#number-container").addClass('hide');
   }else if(type==1){
	   $("#optArr-container-single").addClass('hide');
	    $("#optArr-container-multi").removeClass('hide');
	    $("#qrcode-container").addClass('hide');
	    $("#imgnum-container").addClass('hide');
	    $("#number-container").addClass('hide');
   }else if(type==5){
	   $("#optArr-container-single").addClass('hide');
	   $("#optArr-container-multi").addClass('hide');
	   $("#qrcode-container").removeClass('hide');
	   $("#imgnum-container").addClass('hide');
	   $("#number-container").addClass('hide');
   }else if(type==3){
	   $("#optArr-container-single").addClass('hide');
	   $("#optArr-container-multi").addClass('hide');
	   $("#qrcode-container").addClass('hide');
	   $("#imgnum-container").removeClass('hide');
      $("#number-container").addClass('hide');
   }else if(type==7){
	   $("#optArr-container-single").addClass('hide');
	   $("#optArr-container-multi").addClass('hide');
	   $("#qrcode-container").addClass('hide');
	   $("#imgnum-container").addClass('hide');
	   $("#number-container").removeClass('hide');
	
   }else{
	   $("#optArr-container-single").addClass('hide');
	   $("#optArr-container-multi").addClass('hide');
	   $("#qrcode-container").addClass('hide');
	   $("#imgnum-container").addClass('hide');
	   $("#number-container").addClass('hide');
   }
});

function checkTemplate(){
	if(!$("#template-name").val()){
	    modalMsg("请填写模板标题");
	    return false;
	}

	 showWaiting("正在提交,请稍候...");
	 return true;
}

function check(){
	if(!$("#title").val()){
	    modalMsg("请填写问题描述");
	    return false;
	}
	var opt=0;
	 $("input[name='optArr[]']").each(function(index,item){
		 if($(this).val()){
			 opt++;
		    }
	 });
	 var optM=0;
	 $("input[name='optArrMulti[]']").each(function(index,item){
		 if($(this).val()){
			 optM++;
		    }
	 });

	 
	 var type=$("#type").val();
	 if(type==0){
		    if(opt==0){
			    modalMsg("单选或多选至少要有一个选项");
		        return false;
		    }
	 }else if(type==1){
		  if(optM==0){
			    modalMsg("单选或多选至少要有一个选项");
		        return false;
		    }
	 }else if(type==5){
		 if(!$('#qrcode-value').val()){
			    modalMsg("请填写二维码验证值");
		        return false;
		    }
	 }else if(type==7){
		if(!$('input[name=minnum]').val()||!$('input[name=maxnum]').val()){
			modalMsg("请填写最大值和最小值");
	        return false;
		}    
	 }

	 showWaiting("正在提交,请稍候...");
	 return true;
}

  </script>

