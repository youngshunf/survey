<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
        会员管理
    </div>
</div>
    <div class="box-body">
    <p><a class="btn btn-warning pull-right" href="/user/export-user">导出用户</a></p>

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
            'nick',
            'mobile',
            'alipay',
            'email',
            'address',
            ['attribute'=>'enable',
                'label'=>'启用状态',
                'filter'=>['1'=>'已启用','0'=>'已禁用'],
             'value'=>function ($model){
              return $model->enable==1?'已启用':'已禁用';
            }
            ],
            ['attribute'=>'created_at',
            'format'=>['date','php: Y-m-d H:i:s'],
            ],
             ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'options'=>['width'=>'250px'],
            'template'=>'{view}{update}{delete}{enable}{view-task}',
            'buttons'=>[
              'view'=>function ($url,$model,$key){
                     return Html::a('查看 | ',$url,['title'=>'查看']);
                 
                 },
            'update'=>function ($url,$model,$key){
               
                  return Html::a('修改 | ',$url,['title'=>'修改']);
            },
            'delete'=>function ($url,$model,$key){
             
               return Html::a('删除 | ',$url,['title'=>'删除']);
            },
            'enable'=>function ($url,$model,$key){
             if($model->enable==1){
                 return Html::a('禁用 | ',$url,['title'=>'禁用']);
             }else{
                 return Html::a('启用 | ',$url,['title'=>'启用']);
             }
           
            },
             'view-task'=>function ($url,$model,$key){
                return Html::a('查看任务  ',$url,['title'=>'查看']);   
            },           
                ]
            ],
        ],
    ]); ?>
    </div>
</div>
