<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'orderno',
       
            ['attribute'=>'type',
            'label'=>'订单类型',
            'filter'=>['1'=>'维修','2'=>'保养','3'=>'道路救援','4'=>'商品订单'],
            'options'=>['width'=>'150px'],
            'value'=>function ($model){
               return CommonUtil::getDescByValue('order', 'type', $model->type); 
            }],
            ['attribute'=>'status',
                'label'=>'订单状态',
                'filter'=>['0'=>'待处理','1'=>'待评价','2'=>'已完成','99'=>'已取消'],
                'options'=>['width'=>'150px'],
                'value'=>function ($model){
                return CommonUtil::getDescByValue('order', 'status', $model->status);
            }],
            'user.name',
            'user.nick',
            'shop.name',
            'amount',
              ['attribute'=>'是否支付','value'=>function ($model){
                return $model->is_pay==0?"否":"是";
            }],
             ['attribute'=>'订单时间','value'=>function ($model){
                 return CommonUtil::fomatTime($model->created_at);
             }],
          
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{view}{update}{delete}',
                'buttons'=>[
              
                'view'=>function ($url,$model,$key){
                    if($model->status==0){
                        return Html::a('处理',$url,['title'=>'处理']);
                    }else{
                        return Html::a('查看',$url,['title'=>'查看']);
                    }
             },
                'update'=>function ($url,$model,$key){
                   return Html::a('修改',$url,['title'=>'修改']);
             },
                 'delete'=>function ($url,$model,$key){
                      return Html::a('删除',$url,['title'=>'删除','data'=>['confirm'=>'您确定要删除此订单?']]);
                 },
             
                    ]
             ],
        ],
    ]); ?>

</div>
