<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchTask */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '任务管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">

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
        <?= Html::a('发布任务', ['create'], ['class' => 'btn btn-success']) ?>
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
            'template'=>'{view}{update}{delete}{view-answer}{off-line}',
            'buttons'=>[
//               'recommend'=>function ($url,$model,$key){
//                  if($model->status==2&&$model->is_recommend==0){
//                   return Html::a('推荐 | ',$url,['title'=>'推荐','data'=>['confirm'=>'您确定要推荐此任务吗?','method'=>'post']]);
//                  }elseif($model->status==2&&$model->is_recommend==1){
//                      return Html::a('取消推荐 | ',$url,['title'=>'取消推荐','data'=>['confirm'=>'您确定要取消推荐此任务吗?','method'=>'post']]);
//                  }
//                  },
//             'auth-pass'=>function ($url,$model,$key){
//                if($model->status==1 ||$model->status==99)
//                   return Html::a('审核通过 | ',$url,['title'=>'审核通过','data'=>['confirm'=>'您确定要审核通过此任务吗?','method'=>'post']]);
//             },
//             'auth-deny'=>function ($url,$model,$key){
//                if($model->status==1)
//                return Html::a('审核不通过 | ',$url,['title'=>'审核不通过','data'=>['confirm'=>'您确定要审核不通过此任务吗?','method'=>'post']]);
//             },
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
            
                'view-answer'=>function ($url,$model,$key){
                     return Html::a('任务结果 | ',$url,['title'=>'任务结果']);
                    },
                'off-line'=>function ($url,$model,$key){
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
