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
            ['attribute'=>'created_at',
            'format'=>['date','php: Y-m-d H:i:s'],
            ],
             ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'options'=>['width'=>'250px'],
            'template'=>'{view}{update}{delete}{view-task}',
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
             'view-task'=>function ($url,$model,$key){
                return Html::a('查看任务  ',$url,['title'=>'查看']);   
            },           
                ]
            ],
        ],
    ]); ?>
    </div>
</div>
