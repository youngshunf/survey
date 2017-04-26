<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '维修';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    	'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            ['attribute'=>'status',
            'value'=>function ($model){
            $status=$model->status;
            return empty($status)?"":CommonUtil::getDescByValue('maintenance', 'status', $status);
            },
              'filter'=>['0'=>'待确认','1'=>'待服务','2'=>'待评价','3'=>'已完成','98'=>'预约取消','99'=>'服务取消'],
            ],
//             'phone',
    		['attribute'=>'phone','value'=>function ($model){
    			$phone=$model->phone;
    			return empty($phone)?"":$phone;
    		}],

            ['attribute'=>'r_name','value'=>function ($model){
            	$r_name=$model->r_name;
            	return empty($r_name)?"":$r_name;
            }],
//             'm_name',
            ['attribute'=>'m_name','value'=>function ($model){
            	$m_name=$model->m_name;
            	return empty($m_name)?"":$m_name;
            }],
//             'r_phone',
            ['attribute'=>'r_phone','value'=>function ($model){
            	$r_phone=$model->r_phone;
            	return empty($r_phone)?"":$r_phone;
            }],
//             'm_time',
            ['attribute'=>'m_time','value'=>function ($model){
            	$m_time=$model->m_time;
            	return empty($m_time)?"":CommonUtil::fomatHours($m_time);
            }],
            // 'cancel_book',
            // 'cancel_book_time',
            // 'cancel_m',
            // 'cancel_m_time',
            // 'next_m_time',
//             'created_at',
            ['attribute'=>'created_at','value'=>function ($model){
            	$created_at=$model->created_at;
            	return empty($created_at)?"":CommonUtil::fomatHours($created_at);
            }],
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
	            'header'=>'操作',
	            'template'=>'{view}{update}{delete}{mupdate}{mdelete}{select}',
	            'buttons'=>[
	            
		            'view'=>function ($url,$model,$key){
		            	return  Html::a('<button type="button" class="btn btn-primary">查看详情</button>', $url, ['title' => '查看详情'] );
		            },
		            'update'=>function ($url,$model,$key){
		            	if($model->status == CommonUtil::M_STATUS_1){
		            		return  Html::a('<button type="button" class="btn btn-success">预约确认</button>', $url, ['title' => '预约确认'] );
		            	}
		            },
		            'delete'=>function ($url,$model,$key){
		            	if($model->status == CommonUtil::M_STATUS_1){
		            		return  Html::a('<button type="button" class="btn btn-danger">预约取消</button>', $url, ['title' => '预约取消'] );
		            	}
		            },
		            'mupdate'=>function ($url,$model,$key){
		            	if ($model->status == CommonUtil::M_STATUS_2 /* && time()>=$model->m_time */) {
		            		return  Html::a('<button type="button" class="btn btn-success">服务完成</button>', $url, ['title' => '服务完成'] );	
		            	}
		            },
		            'mdelete'=>function ($url,$model,$key){
		            	if($model->status == CommonUtil::M_STATUS_2 /* && time()<=$model->m_time */){
		            		return  Html::a('<button type="button" class="btn btn-danger">服务取消</button>', $url, ['title' => '服务取消'] );
		            	}
		            },
		            'select'=>function ($url,$model,$key){
		            	if($model->status == CommonUtil::M_STATUS_4){
							return  Html::a('<button type="button" class="btn btn-warning">服务评价</button>', $url, ['title' => '服务评价'] );
						}
		            },
            	]
            ],
        ],
    ]); ?>

</div>
