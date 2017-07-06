<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchProject */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目管理';
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
     <?php if(yii::$app->user->identity->role_id==89 ||yii::$app->user->identity->role_id==88){?>
        <?= Html::a('新建项目', ['create'], ['class' => 'btn btn-warning']) ?>
        <?php }?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'name',
            'tasknum',
            'shop',
            ['attribute'=>'created_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],

            ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
             'template'=>'{view}{update-task}{update}{copy-project}{delete}',
              'buttons'=>[
                  'view'=>function ($url,$model,$key){
                      return Html::a('查看 | ',$url,['title'=>'查看']);
                  },
                  'update-task'=>function ($url,$model,$key){
                  if(yii::$app->user->identity->role_id==89 ||yii::$app->user->identity->role_id==88)
                    return Html::a('修改整体属性 | ',$url,['title'=>'修改整体属性']);
                  },
                  'update'=>function ($url,$model,$key){
                  if(yii::$app->user->identity->role_id==89 ||yii::$app->user->identity->role_id==88)
                  return Html::a('修改项目名称 | ',$url,['title'=>'修改项目名称']);
                  },
                  'copy-project'=>function ($url,$model,$key){
                  if(yii::$app->user->identity->role_id==89 ||yii::$app->user->identity->role_id==88)
                  return Html::a('复制项目 | ',$url,['title'=>'复制项目']);
                  },
                  'delete'=>function ($url,$model,$key){
                  if(yii::$app->user->identity->role_id==89 ||yii::$app->user->identity->role_id==88)
                  return Html::a('删除  ',$url,['title'=>'删除','data'=>['confirm'=>'您确定要删除此项目吗?','method'=>'post']]);
                  },
                  
                  
                 ]
            ],
        ],
    ]); ?>

</div>
</div>