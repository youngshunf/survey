<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWallet */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员财务';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
        <?= Html::encode($this->title) ?>
    </div>
</div>
    <div class="box-body">

    <h5>会员财务明细</h5>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
             ['attribute'=>'user.name',
            'format'=>'html',
            'value'=>function ($model){
                return CommonUtil::truncateName( $model->user->name);
             }
            ],
            ['attribute'=>'user.mobile',
            'format'=>'html',
            'value'=>function ($model){
                return CommonUtil::truncateMobile( $model->user->mobile);
            }
            ],
            ['attribute'=>'user.alipay',
            'format'=>'html',
            'value'=>function ($model){
                return CommonUtil::truncateMobile( $model->user->alipay);
            }
            ],
         
            'amount',
            ['attribute'=>'created_at',
               'label'=>'时间',
              'format'=>['date','php: Y-m-d H:i:s'],
             ],
            ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
             'template'=>'{view}'
            ],
        ],
    ]); ?>

</div>
</div>