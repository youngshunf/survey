<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->order_no;
$this->params['breadcrumbs'][] = ['label' => '订单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="panel-white">
   <div class="col-md-6">
    <h5><?= Html::encode($this->title) ?></h5>

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

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_no',
            'user.name',
            'user.nick',
            'goods_name',
            'amount',
             ['attribute'=>'订单类型','value'=>CommonUtil::getDescByValue('order', 'type', $model->type) ],
            ['attribute'=>'订单状态','value'=>CommonUtil::getDescByValue('order', 'status', $model->status)],
              ['attribute'=>'是否支付','value'=>$model->is_pay==0?"否":"是"],
             ['attribute'=>'订单时间','value'=> CommonUtil::fomatTime($model->created_at)],
        ],
    ]) ?>
     </div>
     
     <div class="col-md-6">
     
     <?php if($model->type==1||$model->type==2){?>
     <h5>服务详情</h5>
     <?php if($biz->status==0){?>
     <p><a class="btn btn-success" href="<?= Url::to(['confirm-maitain-book','id'=>$biz->id])?>">预约确认</a>
     <a class="btn btn-danger" href="<?= Url::to(['cancel-maitain-book','id'=>$biz->id])?>">预约取消</a>
     </p>
     <?php }elseif ($biz==1){?>
     <p><a class="btn btn-success" href="<?= Url::to(['confirm-maitain-service','id'=>$biz->id])?>">服务完成</a>
     <a class="btn btn-danger" href="<?= Url::to(['cancel-maitain-service','id'=>$biz->id])?>">服务取消</a>
     </p>
     <?php }?>
         <?= DetailView::widget([
        'model' => $biz,
        'attributes' => [
             'orderno' ,
            'book_m_date',
           [ 'attribute'=>'type','value'=>CommonUtil::getDescByValue('maintain', 'type', $biz->type)],
            'phone',
            [ 'attribute'=>'status','value'=>CommonUtil::getDescByValue('maintain', 'status', $biz->status)],
            'r_name' ,
            'm_name' ,
            'r_phone' ,
           ['attribute'=>'m_time','value'=> CommonUtil::fomatTime($model->m_time)],
            'cancel_book' ,
            'cancel_book_time',
            'cancel_m' ,
            ['attribute'=>'cancel_m_time','value'=> CommonUtil::fomatTime($model->cancel_m_time)],
            ['attribute'=>'next_m_time','value'=> CommonUtil::fomatTime($model->next_m_time)],
        ['attribute'=>'下单时间','value'=> CommonUtil::fomatTime($model->created_at)],
        ],
    ]) ?>
     
     <?php }?>
     </div>
     
</div>
</div>