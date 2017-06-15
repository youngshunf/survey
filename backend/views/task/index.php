<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchTask */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '任务管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
       <?php if(empty($searchModel->post_type)){?>
       全部任务
       <?php }elseif ($searchModel->post_type==1){?>
       平台任务
       <?php }elseif ($searchModel->post_type==2){?>
       第三方任务
       <?php }?>
    </div>
</div>
    <div class="box-body">
  <p class="pull-right">
        <?= Html::a('发布任务', ['create'], ['class' => 'btn btn-warning']) ?>
       </p>   
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
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
            'max_times',
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
            'template'=>'{recommend}{auth-pass}{auth-deny}{view}{update}{delete}{copy-task}{view-answer}{off-line}{on-line}',
            'buttons'=>[
              'recommend'=>function ($url,$model,$key){
                 if($model->status==2&&$model->is_recommend==0){
                  return Html::a('推荐 | ',$url,['title'=>'推荐','data'=>['confirm'=>'您确定要推荐此任务吗?','method'=>'post']]);
                 }elseif($model->status==2&&$model->is_recommend==1){
                     return Html::a('取消推荐 | ',$url,['title'=>'取消推荐','data'=>['confirm'=>'您确定要取消推荐此任务吗?','method'=>'post']]);
                 }
                 },
            'auth-pass'=>function ($url,$model,$key){
               if($model->status==1 ||$model->status==99)
                  return Html::a('审核通过 | ',$url,['title'=>'审核通过','data'=>['confirm'=>'您确定要审核通过此任务吗?','method'=>'post']]);
            },
            'auth-deny'=>function ($url,$model,$key){
               if($model->status==1)
               return Html::a('审核不通过 | ',$url,['title'=>'审核不通过','data'=>['confirm'=>'您确定要审核不通过此任务吗?','method'=>'post']]);
            },
                'view'=>function ($url,$model,$key){
                return Html::a('查看 | ',$url,['title'=>'查看']);   
            },
                'update'=>function ($url,$model,$key){
               if($model->user_guid==yii::$app->user->identity->user_guid &&$model->status==0){
                    return Html::a('继续设计 | ',$url,['title'=>'继续设计']);
                }else{
                    return Html::a('修改 | ',$url,['title'=>'修改']);
                }
                    },
                'delete'=>function ($url,$model,$key){
                   if(yii::$app->user->identity->role_id==99)
                     return Html::a('删除 | ',$url,['title'=>'删除','data'=>['confirm'=>'您确定要删除此任务吗?','method'=>'post']]);
                },
                'copy-task'=>function ($url,$model,$key){
                if(yii::$app->user->identity->role_id==99)
                    return Html::a('复制任务 | ',$url,['title'=>'复制','data'=>['confirm'=>'您确定要复制此任务吗?','method'=>'post']]);
                },
            
                'view-answer'=>function ($url,$model,$key){
                     return Html::a('任务结果 | ',$url,['title'=>'任务结果']);
                    },
                'off-line'=>function ($url,$model,$key){
                  if($model->status==2)
                    return Html::a('下线 | ',$url,['title'=>'下线任务']);
                    },
                    'on-line'=>function ($url,$model,$key){
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
        
         <form action="<?=Url::to(['on-line'])?>" method="post" id="option-form" onsubmit="return check()">
           <input type="hidden" name="task_id" value="">
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
	$("input[name=task_id]").val(id);
	$("#onLineModal").modal('show');
}

function check(){
	if(!$("input[name=end_time]").val()){
      modalMsg('请选择截止时间!');
      return false;
	}

	showWaiting('正在提交,请稍候...');
	return true;
}

</script>
