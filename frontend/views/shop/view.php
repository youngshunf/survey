<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '店铺管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除此项目?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    <div class="row">
        
        <div class="col-md-6">
     
        <img alt="" src="<?= yii::getAlias('@photo').'/'.$model->path.'/mobile/'.$model->photo?>" class="img-responsive">
        </div>
    
    <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'shopno',
            'name',
            'lng',
            'lat',
            'factory.name',
            'brand.brand_name',
          ['attribute'=>'type','value'=>CommonUtil::getDescByValue('shop', 'type', $model->type)]
    ]     
    ]) ?>
    </div>
    
    <div class="col-md-12">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'address',
            'mobile',
            'email:email',
            'telephone',
            'province',
            'city',
            ['attribute'=>'is_auth','value'=>$model->is_auth==0?'否':'是'],
            ['attribute'=>'创建方式','value'=>CommonUtil::getDescByValue('shop', 'create_type', $model->create_type)],
            ['attribute'=>'created_at',
               'format'=>['date','php:Y-m-d H:i:s'],
            ],
            ['attribute'=>'updated_at',
            'format'=>['date','php:Y-m-d H:i:s'],
            ],
        ],
    ]) ?>
    </div>
    
    <div class="col-md-12">
    <h5>店铺介绍</h5>
        <?= $model->desc?>
    </div>
    
    </div>
</div>
