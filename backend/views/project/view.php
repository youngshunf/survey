<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\CommonUtil;
use common\models\Question;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
      <?= $this->title ?>
    </div>
</div>

   <div class="box-body">
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => '您确定要删除此项目吗?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('修改整体属性', ['update-task', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
         <?= Html::a('复制项目', ['copy-project', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <button class="btn btn-warning importTask">问卷模板批量导入</button>
        <button class="btn btn-warning importTaskTemplate">任务模板批量导入</button>
         <?= Html::a('地图模式', ['view-map', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'tasknum',
            ['attribute'=>'任务进度',
            'value'=>$doneRate.'%',
            ],
           ['attribute'=>'created_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
        ],
    ]) ?>

    
</div>
</div>

     <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">项目问题</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body" style="display: none">
          <a class="btn btn-warning  option" id="option">添加问题</a>
<!--            <a class="btn btn-success  template" id="template">设置为问卷模板</a> -->
           <a class="btn btn-warning"  href="<?= Url::to(['task/choose-template','id'=>$model->id,'project_id'=>@$model->id])?>">从模板库中选择</a>
    <?= GridView::widget([
        'dataProvider' => $questionDataProvider,
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
            'template'=>'{task/move-up}{task/move-down}{task/update-question}{task/delete-question}',
            'buttons'=>[  
                'task/move-up'=>function ($url,$model,$key){
                if($model->code!=1){
                    return Html::a('上移 | ',$url,['title'=>'上移']);
                }
                },
                'task/move-down'=>function ($url,$model,$key){
                $countquestion=Question::find()->andWhere(['task_guid'=>$model->task_guid])->count();
                if($model->code!=$countquestion){
                    return Html::a('下移 | ',$url,['title'=>'下移']);
                }
                },
                'task/update-question'=>function ($url,$model,$key){
                return Html::a('修改 | ',$url,['title'=>'修改']);
                },
                'task/delete-question'=>function ($url,$model,$key){
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
            <form action="<?=Url::to(['task/add-question'])?>" method="post" id="option-form" onsubmit="return check()">
               <input type="hidden" name="task_guid" value="<?= $task->task_guid?>">
               <input type="hidden" name="project_id" value="<?php echo @$model->id ?> ">
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
                  <div class="form-group">
                    <label class="label-control">拍照类型</label>       
                    <select name="phototype" class="form-control">
                    <option value="1">仅拍照</option>
                    <option value="2">拍照和相册选择</option>
                    </select>         
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
            <form action="<?=Url::to(['task/publish-template'])?>" method="post" id="option-form" onsubmit="return checkTemplate()">
           <input type="hidden" name="task_guid" value="<?= $task->task_guid?>">
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
            <form action="<?=Url::to(['task/publish-task-template'])?>" method="post" id="option-form" onsubmit="return checkTaskTemplate()">
           <input type="hidden" name="task_guid" value="<?= $task->task_guid?>">
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



<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
     项目任务
    </div>
</div>
    <div class="box-body">
  <p class="pull-right">
   <?= Html::a('新增任务', ['task/create','project_id'=>$model->id], ['class' => 'btn btn-warning']) ?>
         <?= Html::a('批量发布', ['batch-publish','project_id'=>$model->id], ['class' => 'btn btn-warning']) ?>
         <?= Html::a('批量审核通过', ['batch-pass','project_id'=>$model->id], ['class' => 'btn btn-warning']) ?>
         <?= Html::a('批量导出结果', ['batch-export-answer','project_id'=>$model->id], ['class' => 'btn btn-warning']) ?>
         <?= Html::a('批量导出EXCEL', ['batch-export-excel','project_id'=>$model->id], ['class' => 'btn btn-warning']) ?>
         <?= Html::a('批量下线', ['batch-off-line','project_id'=>$model->id], ['class' => 'btn btn-warning']) ?>
       
       <button class="btn btn-warning" onClick="onLine(<?= $model->id?>)">批量上线</button>
       </p>   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'name',
            ['attribute'=>'type',
              'filter'=>['1'=>'调查','3'=>'招募'],
              'options'=>['width'=>'120px'],
              'value'=>function ($model){
              return CommonUtil::getDescByValue('task', 'type', $model->type);
            }
            ],
            ['attribute'=>'do_type',
            'filter'=>['2'=>'四处跑','1'=>'宅在家'],
            'options'=>['width'=>'120px'],
            'value'=>function ($model){
                return CommonUtil::getDescByValue('task', 'do_type', $model->do_type);
            }
            ],
             'province',
             'city',
               ['attribute'=>'status',
            'filter'=>['0'=>'任务设计中','1'=>'待审核', '2'=>'审核通过','3'=>'已下线','99'=>'审核未通过'],
            'options'=>['width'=>'120px'],
            'value'=>function ($model){
                return CommonUtil::getDescByValue('task', 'status', $model->status);
            }
            ],
             'price',
             'number',
            ['attribute'=>'count_done',
                'label'=>'答案数量',
                'filter'=>['1'=>"答案倒序",'2'=>'答案正序'],
            ],
            ['attribute'=>'latest_submit_time',
                'label'=>'最后提交时间',
                'filter'=>['1'=>"提交时间倒序",'2'=>'提交时间正序'],
                'format'=>['date','php:Y-m-d H:i:s']
                ],
            ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'options'=>['width'=>'250px'],
            'template'=>'{task/recommend}{task/auth-pass}{task/auth-deny}{task/view}{task/update}{task/delete}{task/view-answer}{task/off-line}{task/on-line}',
            'buttons'=>[
              'task/recommend'=>function ($url,$model,$key){
                 if($model->status==2&&$model->is_recommend==0){
                  return Html::a('推荐 | ',$url,['title'=>'推荐','data'=>['confirm'=>'您确定要推荐此任务吗?','method'=>'post']]);
                 }elseif($model->status==2&&$model->is_recommend==1){
                     return Html::a('取消推荐 | ',$url,['title'=>'取消推荐','data'=>['confirm'=>'您确定要取消推荐此任务吗?','method'=>'post']]);
                 }
                 },
            'task/auth-pass'=>function ($url,$model,$key){
               if($model->status==1 ||$model->status==99)
                  return Html::a('审核通过 | ',$url,['title'=>'审核通过','data'=>['confirm'=>'您确定要审核通过此任务吗?','method'=>'post']]);
            },
            'task/auth-deny'=>function ($url,$model,$key){
               if($model->status==1)
               return Html::a('审核不通过 | ',$url,['title'=>'审核不通过','data'=>['confirm'=>'您确定要审核不通过此任务吗?','method'=>'post']]);
            },
                'task/view'=>function ($url,$model,$key){
                return Html::a('查看 | ',['task/view','id'=>$model->id,'project_id'=>$model->project_id],['title'=>'查看']);   
            },
                'task/update'=>function ($url,$model,$key){
               if($model->user_guid==yii::$app->user->identity->user_guid &&$model->status==0){
                    return Html::a('继续设计 | ',$url,['title'=>'继续设计']);
                }else{
                    return Html::a('修改 | ',$url,['title'=>'修改']);
                }
                    },
                'task/delete'=>function ($url,$model,$key){
                return Html::a('删除 | ',$url,['title'=>'删除','data'=>['confirm'=>'您确定要删除此任务吗?','method'=>'post']]);
                },
            
                'task/view-answer'=>function ($url,$model,$key){
                return Html::a('任务结果 | ',$url,['title'=>'任务结果']);
                },
                'task/off-line'=>function ($url,$model,$key){
                if($model->status==2)
                    return Html::a('下线',$url,['title'=>'下线任务','data'=>['confirm'=>'您确定要下线此任务吗?','method'=>'post']]);
                },
                'task/on-line'=>function ($url,$model,$key){
                if($model->status==3)
                    return Html::a('上线','javascript:;',['title'=>'上线任务','onClick'=>"onLine($model->id)"]);
                },
                ]
            ],
        ],
        'tableOptions'=>['class'=>'table table-striped table-responsive'],
    ]); ?>

</div>
</div>


<div class="modal fade" id="importTask" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
            问卷模板批量导入
            </h4>
         </div>
         <div class="modal-body">            	
            <form enctype="multipart/form-data" action="<?=Url::to(['import-task'])?>" method="post" id="option-form" onsubmit="return check()">
           <input type="hidden" name="project_id" value="<?= $model->id?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
            <div class="form-group">
                <label class="label-control">请选择文件</label>
               <input   name="taskfile"  type="file" id="taskfile" class="form-control">
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

<div class="modal fade" id="importTaskTemplate" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
            任务模板批量导入
            </h4>
         </div>
         <div class="modal-body">            	
            <form enctype="multipart/form-data" action="<?=Url::to(['import-task-template'])?>" method="post" id="option-form" onsubmit="return checkTask()">
           <input type="hidden" name="project_id" value="<?= $model->id?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
            <div class="form-group">
                <label class="label-control">请选择文件</label>
               <input   name="tasktemplatefile"  type="file" id="taskfile" class="form-control">
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

<div class="modal fade" id="onLineModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              重新上线
            </h4>
         </div>
         <div class="modal-body">       
        
         <form action="<?=Url::to(['batch-online'])?>" method="post" id="option-form" onsubmit="return checkOnline()">
           <input type="hidden" name="project_id" value="<?= $model->id?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
                <div class="">
                    <label class="label-control">截止时间</label>
                    <input type="date" class="form-control " name="end_time" placeholder="请选择截止时间">
                </div>
                <div class="" style="margin-top:15px">
                 <p class="center"><button type="submit" class="btn btn-info">提交</button></p>
                </div>
               
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

<script type="text/javascript">
function onLine(id){
	$("input[name=project_id]").val(id);
	$("#onLineModal").modal('show');
}

function checkOnline(){
	if(!$("input[name=end_time]").val()){
      modalMsg('请选择截止时间!');
      return false;
	}

	showWaiting('正在提交,请稍候...');
	return true;
}

</script>
    
<script>
$('.importTask').click(function(){
    $("#importTask").modal('show');
});
$('.importTaskTemplate').click(function(){
    $("#importTaskTemplate").modal('show');
});
    function check(){
        if(!$('input[name=taskfile]').val()){
            modalMsg('请选择导入文件...');
            return false;
        }

        showWaiting('正在导入,请稍候...');
        return true;
    }

    function checkTask(){
        if(!$('input[name=tasktemplatefile]').val()){
            modalMsg('请选择导入文件...');
            return false;
        }

        showWaiting('正在导入,请稍候...');
        return true;
    }
</script>

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