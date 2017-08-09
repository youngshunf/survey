<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCircle */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '车友圈管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>[
        'firstPageLabel'=>'第一页',
        'lastPageLabel'=>'最后一页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],

            'user.nick',   
            'user.mobile',    
            'content:ntext',
            // 'permisssions',
             'count_reply',
             'count_love',
            // 'city',
             'address',
           
         ['attribute'=>'时间','value'=>function ($model){
            return CommonUtil::fomatTime($model->created_at); 
         }],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
