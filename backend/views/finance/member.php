<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            'non_payment',
            'paid',
            'total_income',
             'withdrawing',
//             ['class' => 'yii\grid\ActionColumn',
//             'header'=>'操作',
//              'template'=>'{view}'
//             ],
        ],
    ]); ?>

</div>
</div>