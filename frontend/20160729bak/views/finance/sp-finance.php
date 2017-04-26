<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWallet */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '财务管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

<div class="box-header width-border"> 
    <div class="box-title" >
        <?= Html::encode($this->title) ?>
    </div>
</div>
    <div class="box-body">

    <h5>财务管理</h5>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'user.mobile',
            'balance',
            'frozen_amount',
            'total_amount',
            ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            ],
        ],
    ]); ?>

</div>
</div>