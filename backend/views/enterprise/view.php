<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\UserEnterprise */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '商户关管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">
    <div class="row">
    
    <div class="col-md-12">
    
    <h5>账户信息</h5>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除此用户?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'role_id',
            'email:email',
            'mobile',
            'telephone',
            ['attribute'=>'注册时间','value'=>CommonUtil::fomatTime($model->created_at)],
            'last_ip',
             ['attribute'=>'上次登录时间','value'=>CommonUtil::fomatTime($model->last_login_time)],
        ],
    ]) ?>
    
    </div>
    
    <div class="col-md-12">
        <h5>店铺
     
        </h5>
            
       
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
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{view-shop}',
                'buttons'=>[
                    'view-shop'=>function ($url,$model,$key){
                    return Html::a('查看店铺信息',['shop/view','id'=>$key],['title'=>'查看店铺信息']);
             }
                    ]
             ],
        ],
    ]); ?>
    
    <div id='relate-shop'>
    <h3>关联店铺</h3>
    <form action="<?= Url::to(['relate-shop'])?>" method ="post"  onsubmit="return check()">
    <input type="hidden" name="_csrf"  value="<?= yii::$app->getRequest()->getCsrfToken()?>">
    <input type="hidden" name="user_guid" value="<?= $model->user_guid?>">
    
    <?= ListView::widget([
          'dataProvider'=>$noMasterShopData,
          'itemView'=>'_shop_item',            
           'layout'=>"{items}\n{pager}"
    ])?>
    <p class="center">
    <button type="submit" class="btn btn-success">确认关联</button>
    </p>
    </form>
    
    </div>
    </div>
    
    
    
    </div>
    

    

</div>
<script>

function check(){
	   var users=0;
	   $("input[type=checkbox]:checked").each(function(){
		    users++;
	   });

	   if(users==0){
		    modalMsg("请选择店铺再提交");
		    return false;
	   }

	   showWaiting("正在提交,请稍候...");
	   return true;
}
 </script>