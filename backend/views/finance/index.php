<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWallet */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '平台财务';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
        平台财务总览
    </div>
</div>
    <div class="box-body">

     <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">任务总额</span>
                  <span class="info-box-number">1,410</span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">会员收益</span>
                  <span class="info-box-number">410</span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">第三方充值</span>
                  <span class="info-box-number">13,648</span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">已发放金额</span>
                  <span class="info-box-number">93,139</span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
</div>
</div>
      <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 >会员提现记录</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
              [
            'attribute' => 'name',
            'value' => 'user.name',
            'label' => '姓名',
            ],
            [
            'attribute' => 'mobile',
            'value' => 'user.mobile',
            'label' => '手机号',
            ],  
            'user.alipay',
            ['attribute' => 'address',
            'value' => 'user.address',
            'label' => '地址',
            ], 
            'amount',
            ['attribute'=>'status',
              'filter'=>['0'=>'待付款','1'=>'已付款','99'=>'已驳回'],
            'value'=>function ($model){
            return CommonUtil::getDescByValue('withdraw', 'status', $model->status);
             },
            ],
            ['attribute'=>'created_at',
            'value'=>function ($model){
            return CommonUtil::fomatTime($model->created_at);
             },
            ],

            ['class' => 'yii\grid\ActionColumn',
               'header'=>'操作',
                'template'=>"{pay-money}{refuse-pay}",
                'buttons'=>[
                        'pay-money'=>function  ($url,$model,$key) {
                        if($model->status==0)
                        return Html::a('付款',$url,['class'=>'btn btn-warning']);
                     },
                     'refuse-pay'=>function  ($url,$model,$key) {
                     if($model->status==0)
                         return Html::a('驳回',$url,['class'=>'btn btn-warning']);
                     },
                     ]
    ],
        ],
    ]); ?>

</div>
</div>

   <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 >第三方充值记录</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $orders,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
                    'user.name',
                    'user.mobile',
                    'amount',
                    'is_pay',
                   ['attribute'=>'created_at',
                    'format'=>['date','php: Y-m-d H:i:s'],
                    ],
        
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

</div>
</div>