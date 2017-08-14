<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
      <?= $this->title ?>
    </div>
</div>

   <div class="box-body">
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => '您确定要删除此项目吗?',
                'method' => 'post',
            ],
        ]) ?>
         <?= Html::a('修改整体属性', ['update-task', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <button class="btn btn-primary importTask">问卷模板批量导入</button>
        <button class="btn btn-primary importTaskTemplate">任务模板批量导入</button>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'tasknum',
           ['attribute'=>'created_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
        ],
    ]) ?>

    
</div>
</div>

<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
     项目任务
    </div>
</div>
    <div class="box-body">
  <p class="pull-right">
   <?= Html::a('新增任务', ['task/create','project_id'=>$model->id], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('批量发布', ['batch-publish','project_id'=>$model->id], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('批量导出结果', ['batch-export-answer','project_id'=>$model->id], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('批量导出EXCEL', ['batch-export-excel','project_id'=>$model->id], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('批量下线', ['batch-off-line','project_id'=>$model->id], ['class' => 'btn btn-primary']) ?>
        <button class="btn btn-primary" onClick="onLine(<?= $model->id?>)">批量上线</button>
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
            'filter'=>['1'=>'宅在家','2'=>'四处跑'],
            'options'=>['width'=>'120px'],
            'value'=>function ($model){
                return CommonUtil::getDescByValue('task', 'do_type', $model->do_type);
            }
            ],
             'province',
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
            'template'=>'{task/recommend}{task/auth-pass}{task/auth-deny}{task/view}{task/update}{task/delete}{task/view-answer}{task/view-answer}',
            'buttons'=>[
//               'task/recommend'=>function ($url,$model,$key){
//                  if($model->status==2&&$model->is_recommend==0){
//                   return Html::a('推荐 | ',$url,['title'=>'推荐','data'=>['confirm'=>'您确定要推荐此任务吗?','method'=>'post']]);
//                  }elseif($model->status==2&&$model->is_recommend==1){
//                      return Html::a('取消推荐 | ',$url,['title'=>'取消推荐','data'=>['confirm'=>'您确定要取消推荐此任务吗?','method'=>'post']]);
//                  }
//                  },
//             'task/auth-pass'=>function ($url,$model,$key){
//                if($model->status==1 ||$model->status==99)
//                   return Html::a('审核通过 | ',$url,['title'=>'审核通过','data'=>['confirm'=>'您确定要审核通过此任务吗?','method'=>'post']]);
//             },
//             'task/auth-deny'=>function ($url,$model,$key){
//                if($model->status==1)
//                return Html::a('审核不通过 | ',$url,['title'=>'审核不通过','data'=>['confirm'=>'您确定要审核不通过此任务吗?','method'=>'post']]);
//             },
                'task/view'=>function ($url,$model,$key){
                return Html::a('查看 | ',$url,['title'=>'查看']);   
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
                    return Html::a('下线',$url,['title'=>'下线任务']);
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
           <input type="hidden" name="project_id" value="<?= $model->id ?>">
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