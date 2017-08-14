<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '商品管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">
 
    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定删除此项目?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
   <div class="row">
    
    <div class="col-md-12">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'price',
            'number',
            'shop.name',
            ['attribute'=>'是否上架',
            'value'=>$model->is_sale==0?'否':'是'],
            ['attribute'=>'type','value'=>CommonUtil::getDescByValue('goods', 'type', $model->type)],
            ['attribute'=>'下架时间','value'=>CommonUtil::fomatTime($model->end_time)],
            ['attribute'=>'创建时间','value'=>CommonUtil::fomatTime($model->created_at)],
              ['attribute'=>'更新时间','value'=>CommonUtil::fomatTime($model->updated_at)],
        ],
        'options' => ['class' => 'table table-striped table-responsive detail-view'],
    ]) ?>
    </div>
    <div class="col-md-12">
        <img alt="" src="<?= yii::getAlias('@photo').'/'.$model->path.'/mobile/'.$model->photo?>" class="img-responsive" >
    </div>
    <div class="col-md-12">
    <h3>商品描述</h3>
    <?= $model->desc?>
    </div>
</div>
</div>
