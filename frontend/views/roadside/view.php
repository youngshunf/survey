<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Roadside */

$this->title = $model->roadside_num;
$this->params['breadcrumbs'][] = ['label' => '道路救援', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>
<!-- 
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
 -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'roadside_num',
            'user.nick',
            'user.name',
            'fours.company',
             'fours.address',
            'lng',
            'lat',
            'phone',
//             'rescue_name',
			['attribute'=>'rescue_name','value'=>empty($model->rescue_name)?"":$model->rescue_name],
//             'rescue_phone',
			['attribute'=>'rescue_phone','value'=>empty($model->rescue_phone)?"":$model->rescue_phone],
//             'status',
    		['attribute'=>'status','value'=>$model->status===NULL?"":CommonUtil::getDescByValue('roadside', 'status', $model->status)],
//             'cancel_rescue',
			['attribute'=>'cancel_rescue','value'=>empty($model->cancel_rescue)?"":$model->cancel_rescue],
//             'arrive_time',
    		['attribute'=>'arrive_time','value'=>empty($model->arrive_time)?"":CommonUtil::fomatHours($model->arrive_time)],
//             'created_at',
    		['attribute'=>'created_at','value'=>empty($model->created_at)?"":CommonUtil::fomatDate($model->created_at)],
//             'updated_at',
    		['attribute'=>'updated_at','value'=>empty($model->updated_at)?"":CommonUtil::fomatDate($model->updated_at)],
        ],
    ]) ?>

</div>
