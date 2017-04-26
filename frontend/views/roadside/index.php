<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '道路救援管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'orderno',
            'user.name',   
    		['attribute'=>'phone','value'=>function ($model){
    			$phone=$model->phone;
    			return empty($phone)?"":$phone;
    		}], 
            ['attribute'=>'status','value'=>function ($model){
            	$status=$model->status;
            	return CommonUtil::getDescByValue('roadside', 'status', $status);
            },
            'filter'=>['0'=>'待确认','1'=>'待救援','2'=>'待评价','3'=>'已完成','99'=>'服务取消'],
            ],

            ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'template'=>'{view}{update}{delete}{complete}{select}',
            'buttons'=>[
            	'view'=>function ($url,$model,$key){
            		return  Html::a('<button type="button" class="btn btn-primary">查看详情</button>', $url, ['title' => '查看详情'] );
            	},
            	'update'=>function ($url,$model,$key){
            		if($model->status == CommonUtil::R_STATUS_0){
            			return  Html::a('<button type="button" class="btn btn-success">确认救援</button>', $url, ['title' => '确认救援'] );
            		}
            	},
		        'delete'=>function ($url,$model,$key){
            		if($model->status == CommonUtil::R_STATUS_0 || $model->status == CommonUtil::R_STATUS_1){
            			return  Html::a('<button type="button" class="btn btn-danger">救援取消</button>', $url, ['title' => '救援取消'] );
            		}
            	},
            	'complete'=>function ($url,$model,$key){
            		if($model->status == CommonUtil::R_STATUS_1){
            			return  Html::a('<button type="button" class="btn btn-info">救援完成</button>', $url, ['title' => '救援完成',
            			    'data' => [
                              'confirm' => '您确定救援已经完成了吗？',             
                                ],
            			] );
            		}
            	},
            	'select'=>function ($url,$model,$key){
            		if($model->status == CommonUtil::M_STATUS_2){
            			return  Html::a('<button type="button" class="btn btn-warning">服务评价</button>', $url, ['title' => '服务评价'] );
            		}
            	},
            	]
            ],
        ],
    ]); ?>

</div>