<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

 <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">任务结果</h3>
                  <div class="box-tools pull-right">
                  </div><!-- /.box-tools -->
                  <div class="clear"></div>
                </div><!-- /.box-header -->
                <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'user.mobile',
           
             ['attribute'=>'status',
            'format'=>'html',
            'value'=>function ($model){
             return CommonUtil::getDescByValue('answer', 'status', $model->status);
            }
            ],
            ['attribute'=>'first_auth',
            'format'=>'html',
            'value'=>function ($model){
                return CommonUtil::getDescByValue('answer', 'first_auth', $model->first_auth);
            }
            ],
            ['attribute'=>'second_auth',
            'format'=>'html',
            'value'=>function ($model){
                return CommonUtil::getDescByValue('answer', 'second_auth', $model->second_auth);
            }
            ],
            ['attribute'=>'start_time',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            'start_address',
            ['attribute'=>'end_time',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            'submit_address',

            ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'options'=>['width'=>'150px'],
            'template'=>'{view-answer-detail}{view-answer-auth}',
            'buttons'=>[  
                'view-answer-detail'=>function ($url,$model,$key){
                return Html::a('查看结果详情 | ',$url);
                },
                'view-answer-auth'=>function ($url,$model,$key){
                return Html::a('查看审核结果',$url);
                },
            
                ]
            ],
        ],
        
        'tableOptions'=>['class'=>'table table-striped table-responsive'],
    ]); ?>
    
    
</div>
</div>

