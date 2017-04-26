<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = $model->id;

$this->params['breadcrumbs'][] = ['label' => '用户评价管理', 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">
<h3>评价服务</h3>
 <?php if($model->type == CommonUtil::M_TYPE ||$model->type==CommonUtil::REPAIR_TYPE){?>
 
 	<?= DetailView::widget([
        'model' => $relation,
        'attributes' => [
			'user.name',
			['attribute'=>'type','value'=> empty($relation->type)?"":CommonUtil::getDescByValue('maintenance', 'type', $relation->type)],
			['attribute'=>'phone','value'=> empty($relation->phone)?"":$relation->phone],
			['attribute'=>'status','value'=> empty($relation->status)?"":CommonUtil::getDescByValue('maintenance', 'status', $relation->status)],
			['attribute'=>'r_name','value'=> empty($relation->r_name)?"":$relation->r_name],
			['attribute'=>'m_name','value'=> empty($relation->m_name)?"":$relation->m_name],
			['attribute'=>'r_phone','value'=> empty($relation->r_phone)?"":$relation->r_phone],
			['attribute'=>'m_time','value'=> empty($relation->m_time)?"":CommonUtil::fomatHours($relation->m_time)],
			['attribute'=>'created_at','value'=>empty($relation->created_at)?"":CommonUtil::fomatDate($relation->created_at)],
        ],
    ]) ?>
 <?php }else if($model->type == CommonUtil::R_TYPE){?>
 	<?= DetailView::widget([
        'model' => $relation,
        'attributes' => [
			'roadside_num',
            'user.nick',
            'user.name',
            'fours.company',
			['attribute'=>'fours_id','value'=>empty($relation->fours_id)?"":$relation->fours_id],	
            'phone',
			['attribute'=>'rescue_name','value'=>empty($relation->rescue_name)?"":$relation->rescue_name],
			['attribute'=>'rescue_phone','value'=>empty($relation->rescue_phone)?"":$relation->rescue_phone],
    		['attribute'=>'status','value'=>$relation->status===NULL?"":CommonUtil::getDescByValue('roadside', 'status', $relation->status)],
    		['attribute'=>'arrive_time','value'=>empty($relation->arrive_time)?"":CommonUtil::fomatHours($relation->arrive_time)],
    		['attribute'=>'created_at','value'=>empty($relation->created_at)?"":CommonUtil::fomatDate($relation->created_at)],
        ],
    ]) ?>
 <?php }?>
 	
 <h3>用户评价内容</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.name',
            'content:ntext',
           ['attribute'=>'type','value'=>CommonUtil::getDescByValue('comment', 'type', $model->type)],
            'star',

			['attribute'=>'created_at','value'=>empty($model->created_at)?"":CommonUtil::fomatDate($model->created_at)],

			['attribute'=>'updated_at','value'=>empty($model->updated_at)?"":CommonUtil::fomatDate($model->updated_at)],

        ],
    ]) ?>

</div>
