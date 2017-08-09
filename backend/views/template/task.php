<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchTemplate */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '任务模板管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
      <?= $this->title ?>
    </div>
</div>

   <div class="box-body">
    <p>
        <?php // Html::a('新建模板', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'name',
            'task_templateno',
            ['attribute'=>'created_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],

            ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'template'=>'{view-task}{delete-task}',
            'buttons'=>[
                'view-task'=>function ($url,$model,$key){
                return Html::a('查看 | ',$url);
            },
            'delete-task'=>function ($url,$model,$key){
            return Html::a('删除 ',$url,['data-confirm'=>'您确定要删除此模板吗?']);
            }
                ]
            ],
        ],
    ]); ?>

</div>
</div>
