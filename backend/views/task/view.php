<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Question;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->name;
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

    <p>
    <?php if(yii::$app->user->identity->role_id==99){?>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => '您确定要删除此任务?',
                'method' => 'post',
            ],
        ]) ?>
        <a class="btn btn-warning  option" id="option">添加问题</a>
        <?php if($model->user_guid==yii::$app->user->identity->user_guid&&$model->status==0){?>
           <?= Html::a('发布任务', ['post', 'id' => $model->id], ['class' => 'btn btn-info',   'data' => [
                'confirm' => '您确定要发布此任务吗?',
            ],]) ?>
        <?php }?>
     <?php }?>
     <a class="btn btn-warning  template" id="task-template">设置为任务模板</a>
       <a class="btn btn-warning" href="<?= Url::to(['copy-task','id'=>$model->id])?>" >复制任务</a>
        <a class="btn btn-warning" href="javascript:;" onclick="history.go(-1)">返回</a>
    </p>
    <div class="row">
    <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            ['attribute'=>'发布者',
            'value'=>$model->user->username
            ],
            ['attribute'=>'post_type',
            'value'=>CommonUtil::getDescByValue('task', 'post_type', $model->post_type)
            ],
            ['attribute'=>'answer_type',
            'value'=>CommonUtil::getDescByValue('task', 'answer_type', $model->answer_type)
            ],
             ['attribute'=>'type',          
               'value'=>CommonUtil::getDescByValue('task', 'type', $model->type)
            ],
            ['attribute'=>'do_type',
            'value'=>CommonUtil::getDescByValue('task', 'do_type', $model->do_type)
            ],
            
            'radius',
            'do_radius',
            'answer_radius',
            'price',
            'number',
            'total_price',
            
            ['attribute'=>'end_time',
            'label'=>'任务截止时间',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
        ],
    ]) ?>
        </div>
         <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        ['attribute'=>'status',
        'value'=>CommonUtil::getDescByValue('task', 'status', $model->status)
        ],
        ['attribute'=>'group_id',
            'value'=>$model->group_id==0?"所有人":$model->group->group_id
        ],
    
            'province',
            'city',
            'district',
            'address',
            'lng',
            'lat',
            ['attribute'=>'created_at',
               'label'=>'创建时间',
               'format'=>['date','php:Y-m-d H:i:s']
            ],
            ['attribute'=>'updated_at',
            'label'=>'更新时间',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
     
        ],
    ]) ?>
        </div>
        
        </div>
    </div>
    </div>
    
    <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">任务描述</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                <?= $model->desc?>
         </div>
         </div>

      <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">任务问题</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
          <a class="btn btn-warning  option" id="option">添加问题</a>
           <a class="btn btn-warning  template" id="template">设置为问卷模板</a>
           <a class="btn btn-warning"  href="<?= Url::to(['choose-template','id'=>$model->id,'project_id'=>@$project_id])?>">从模板库中选择</a>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'name',
            'code',
             ['attribute'=>'type',
            'label'=>'题型',
            'format'=>'html',
            'value'=>function ($model){
             return CommonUtil::getDescByValue('question', 'type', $model->type);
            }
            ],
            ['attribute'=>'required',
            'label'=>'是否必答',
            'format'=>'html',
            'value'=>function ($model){
                return $model->required==1?'是':'否';
            }
            ],
            ['attribute'=>'options',
            'label'=>'选项',
            'format'=>'html',
            'value'=>function ($model){
              $option="";
              if($model->type==0){
                  $options=json_decode($model->options,true);
                  $i=1;
                  foreach ( $options as $v){
                      $option .='<p><span class="green">选项'.$i++.':</span>'.$v['opt'];
                      if(!empty($v['link'])){
                          $option .=';跳转到:题目'.$v['link'];
                      }
                  }
              }elseif ($model->type==1){
                  $options=json_decode($model->options,true);
                  $i=1;
                  foreach ( $options as $v){
                      $option .='<p><span class="green">选项'.$i++.':</span>'.$v;
                  }
              }elseif ($model->type==7){
                  $options=json_decode($model->options,true);
                  $option='最小值:'.$options['min'].';最大值:'.$options['max'];
              }
              return $option;
            }
            ],
            ['attribute'=>'created_at',
            'label'=>'创建时间',
            'format'=>['date','php:Y-m-d H:i:s']
            ],


            ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'options'=>['width'=>'180px'],
            'template'=>'{move-up}{move-down}{update-question}{delete-question}',
            'buttons'=>[  
                'move-up'=>function ($url,$model,$key){
                if($model->code!=1){
                    return Html::a('上移 | ',$url,['title'=>'上移']);
                }
                },
                'move-down'=>function ($url,$model,$key){
                $countquestion=Question::find()->andWhere(['task_guid'=>$model->task_guid])->count();
                if($model->code!=$countquestion){
                    return Html::a('下移 | ',$url,['title'=>'下移']);
                }
                },
                'update-question'=>function ($url,$model,$key){
                return Html::a('修改 | ',$url,['title'=>'修改']);
                },
                'delete-question'=>function ($url,$model,$key){
                return Html::a('删除',$url,['title'=>'删除','data-confirm'=>'您确定要删除这个问题?']);
                },
            
                ]
            ],
        ],
        
        'tableOptions'=>['class'=>'table table-striped table-responsive'],
    ]); ?>
    
    <div class="modal fade" id="addoption" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              增加问题
            </h4>
         </div>
         <div class="modal-body">            	
            <form action="<?=Url::to(['add-question'])?>" method="post" id="option-form" onsubmit="return check()">
               <input type="hidden" name="task_guid" value="<?= $model->task_guid?>">
               <input type="hidden" name="project_id" value="<?php echo @$project_id ?> ">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
          
            <div class="form-group">
                <label class="label-control">问题描述</label>
               <textarea rows="3"  name="name" id="title" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <input type="checkbox" name="required"  value="1">  <label class="label-control">是否必答题</label>
            </div>
            <div class="form-group">
                <label class="label-control">问题类型</label>
               <select name="type" id="type" class="form-control">
               <option value="0">单选题</option>
               <option value="1">多选题</option>
               <option value="2">文本题</option>
               <option value="3">图片题</option>
               <option value="4">语音题</option>
               <option value="5">二维码题</option>
               <option value="6">定位题</option>
               <option value="7">数值题</option>
               </select>
            </div>
            <div id="optArr-container-single" >
            <div id="optArr">
            <div class="input-group">
                 <span class="input-group-addon">选项1</span>
                 <input type="text" class="form-control" name="optArr[]" >
                 <span class="input-group-addon">跳转到</span>
                 <input type="number" class="form-control" name="link[]"  placeholder="题目编号">        
                <span class="input-group-addon">关联引用</span>
                 <input type="number" class="form-control" name="refer[]"  placeholder="题目编号">        
             
              </div>
              <div>
               <input type="hidden"  name="open[]"   value="0">
                <input type="checkbox"  name="opencheck"  value="1"  >
                <label >开放选项</label>
             </div>
            </div>
               <p class="pull-right"><a id="addOpt" href="javascript:;"><span class="glyphicon glyphicon-plus " style="color: red;font-size:26px"> </span></a></p>
                <p class="clear"></p>
                </div>
                
             <div id="optArr-container-multi"  class="hide">
            <div id="optArr-multi">
                <div class="form-group">
                    <label class="label-control">选项1</label>                
                 <input type="text" name="optArrMulti[]" class="form-control">                                  
                </div>
            </div>
               <p class="pull-right"><a id="addOpt-multi" href="javascript:;"><span class="glyphicon glyphicon-plus " style="color: red;font-size:26px"> </span></a></p>
                <p class="clear"></p>
                </div>
                
                <div id="qrcode-container"  class="hide">
           
                <div class="form-group">
                    <label class="label-control">二维码验证值</label>                
                    <input type="text" name="qrcode-value" class="form-control" id="qrcode-value">                                  
                </div>
         
           
                </div>
                
                <div id="imgnum-container"  class="hide">
           
                <div class="form-group">
                    <label class="label-control">上传图片数量</label>                
                    <input type="number" name="imgnum" class="form-control" id="imgnum">                                  
                </div>
                </div>
                
               <div id="number-container"  class="hide">
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
                
                <p class="center"><button type="submit" class="btn btn-warning">提交</button></p>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
</div><!-- /.modal -->

<div class="modal fade" id="addTemplate" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              设置问卷模板
            </h4>
         </div>
         <div class="modal-body">            	
            <form action="<?=Url::to(['publish-template'])?>" method="post" id="option-form" onsubmit="return checkTemplate()">
           <input type="hidden" name="task_guid" value="<?= $model->task_guid?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
          
            <div class="form-group">
                <label class="label-control">设置问卷模板标题</label>
               <input   name="template-name" id="template-name" class="form-control">
            </div>
                
                <p class="center"><button type="submit" class="btn btn-info">提交</button></p>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
</div><!-- /.modal -->


<div class="modal fade" id="addTaskTemplate" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              设置任务模板
            </h4>
         </div>
         <div class="modal-body">            	
            <form action="<?=Url::to(['publish-task-template'])?>" method="post" id="option-form" onsubmit="return checkTaskTemplate()">
           <input type="hidden" name="task_guid" value="<?= $model->task_guid?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
          
            <div class="form-group">
                <label class="label-control">设置任务模板标题</label>
               <input   name="template-name" id="task-template-name" class="form-control">
            </div>
                
                <p class="center"><button type="submit" class="btn btn-info">提交</button></p>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
</div><!-- /.modal -->

</div>
</div>
<script>
$('.option').click(function(){
    $("#addoption").modal('show');
});
$('#template').click(function(){
    $("#addTemplate").modal('show');
});
$('#task-template').click(function(){
    $("#addTaskTemplate").modal('show');
});
var i=1;
$("#addOpt-multi").click(function(){
	i++;
    var innerHtml='<div class="form-group">\
        <label class="label-control">选项'+i+'</label><input type="text" name="optArrMulti[]" class="form-control"></div>';
    $("#optArr-multi").append(innerHtml);
});
 var j=1;
$("#addOpt").click(function(){
	j++;
    var innerHtml='<div class="input-group">\
        <span class="input-group-addon">选项'+j+'</span>\
        <input type="text" class="form-control" name="optArr[]" >\
        <span class="input-group-addon">跳转到</span>\
        <input type="number" class="form-control" name="link[]"  placeholder="请输入题目编号">\
        <span class="input-group-addon">关联引用</span>\
        <input type="number" class="form-control" name="refer[]"  placeholder="题目编号"></div>\
        <div><input type="hidden"  name="open[]"   value="0">\
        <input type="checkbox"  name="opencheck"  value="1"  >\
       <label >开放选项</label></div> ';
    $("#optArr").append(innerHtml);
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
	    modalMsg("请填写问卷模板标题");
	    return false;
	}

	 showWaiting("正在提交,请稍候...");
	 return true;
}

function checkTaskTemplate(){
	if(!$("#task-template-name").val()){
	    modalMsg("请填写任务模板标题");
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
// 		 if(!$('#qrcode-value').val()){
// 			    modalMsg("请填写二维码验证值");
// 		        return false;
// 		    }
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

