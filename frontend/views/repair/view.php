<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Maintenance */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '维修保养管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

			'user.nick',
    		'user.name',

//             'fours_id',
    		['attribute'=>'fours_id','value'=>empty($model->fours_id)?"":$model->fours_id],

    		['attribute'=>'book_time','value'=>empty($model->book_time)?"":CommonUtil::fomatDate($model->book_time)],

    		['attribute'=>'book_m_date','value'=>empty($model->book_m_date)?"":CommonUtil::fomatDate($model->book_m_date)],

    		['attribute'=>'type','value'=>empty($model->type)?"":CommonUtil::getDescByValue('maintenance', 'type', $model->type)],

    		['attribute'=>'phone','value'=>empty($model->phone)?"":$model->phone],

    		['attribute'=>'status','value'=>empty($model->status)?"":CommonUtil::getDescByValue('maintenance', 'status', $model->status)],

    		['attribute'=>'r_name','value'=>empty($model->r_name)?"":$model->r_name],
//             'm_name',
    		['attribute'=>'m_name','value'=>empty($model->m_name)?"":$model->m_name],
//             'r_phone',
    		['attribute'=>'r_phone','value'=>empty($model->r_phone)?"":$model->r_phone],
//             'm_time',
    		['attribute'=>'m_time','value'=>empty($model->m_time)?"":CommonUtil::fomatHours($model->m_time)],
//             'cancel_book',
    		['attribute'=>'cancel_book','value'=>empty($model->cancel_book)?"":$model->cancel_book],
//             'cancel_book_time',
    		['attribute'=>'cancel_book_time','value'=>empty($model->cancel_book_time)?"":CommonUtil::fomatHours($model->cancel_book_time)],
//             'cancel_m',
    		['attribute'=>'cancel_m','value'=>empty($model->cancel_m)?"":$model->cancel_m],
//             'cancel_m_time',
    		['attribute'=>'cancel_m_time','value'=>empty($model->cancel_m_time)?"":CommonUtil::fomatHours($model->cancel_m_time)],
//             'next_m_time',
    		['attribute'=>'next_m_time','value'=>empty($model->next_m_time)?"":CommonUtil::fomatDate($model->next_m_time)],
//             'created_at',
			['attribute'=>'created_at','value'=>empty($model->created_at)?"":CommonUtil::fomatHours($model->created_at)],
//             'updated_at',
			['attribute'=>'updated_at','value'=>empty($model->updated_at)?"":CommonUtil::fomatHours($model->updated_at)],
        ],
    ]) ?>

</div>
