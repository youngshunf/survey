<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchAdminUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '第三方管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
        第三方管理员
    </div>
</div>
    <div class="box-body">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
          
            'username',
            ['attribute'=>'role_id',
            'label'=>'角色',
            'value'=>function ($model){
            return CommonUtil::getDescByValue('admin_user', 'role_id', $model->role_id);
            }
            ],
             'name',
             ['attribute'=>'last_time',
            'format'=>['date','php: Y-m-d H:i:s'],
            ],
     

            ['class' => 'yii\grid\ActionColumn',
              'header'=>'操作',
               'template'=>'{view}{update}{delete}{login-rec}',
                'buttons'=>[
                       'view'=>function ($url,$model,$keyl){
                       return Html::a('查看 | ',$url,['title'=>'查看详情']);
                      },
                      'update'=>function ($url,$model,$key){
                      if(yii::$app->user->identity->role_id==99 || yii::$app->user->identity->user_guid==$model->user_guid){
                            return Html::a('修改 | ',$url,['title'=>'修改']);
                        }
                      },
                      'delete'=>function ($url,$model,$key){
                      return Html::a('删除 |',$url,['title'=>'删除','data'=>['confirm'=>'您确定要删除此用户吗?','method'=>'post']]);
                      },
                      'login-rec'=>function ($url,$model,$key){
                      return Html::a('登录日志',$url,['title'=>'登录日志']);
                      }, 
                    ]
            ],
        ],
    ]); ?>

</div>
</div>