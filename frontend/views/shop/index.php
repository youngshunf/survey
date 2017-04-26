<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchShop */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '店铺管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建店铺', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'name',
             ['attribute'=>'type',
             'value'=>function ($model){
              return CommonUtil::getDescByValue('shop', 'type', $model->type);
             },
             'filter'=>['0'=>'4S店','1'=>'第三方服务商'],
             ],
             'address',
             'mobile',
             ['attribute'=>'create_type',
                'label'=>'创建方式',
               'value'=>function ($model){
                 return CommonUtil::getDescByValue('shop', 'create_type', $model->create_type);
             },
             'filter'=>['0'=>'商户创建','1'=>'管理员创建','2'=>'批量导入'],
             ],
             ['attribute'=>'created_at',
             'label'=>'创建时间',
             'format'=>['date', 'php:Y-m-d H:i:s'],
             ],
            ['class' => 'yii\grid\ActionColumn','header'=>'操作'],
        ],
    ]); ?>

</div>
