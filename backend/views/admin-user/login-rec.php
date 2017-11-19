<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchAdminUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '登录日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
       登录日志
    </div>
</div>
    <div class="box-body">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'adminuser.username',
            'ip',
            'address',
            ['attribute'=>'time',
            'label'=>'登录时间',
            'value'=>function ($model){
            return CommonUtil::fomatTime($model->time);
            }
            ],
           
        ],
    ]); ?>

</div>
</div>