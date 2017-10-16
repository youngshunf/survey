<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GroupUser;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use common\models\Task;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->mobile;
$this->params['breadcrumbs'][] = ['label' => '用户分组', 'url' => ['group']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">


    <div class="box-body">
<p class="btn btn-warning"  >用户参与任务</p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'user.mobile',  
            'user.alipay',
            'task.name',
            ['attribute'=>'created_at',
            'label'=>'领取时间',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            ['attribute'=>'end_time',
            'label'=>'提交答案时间',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{taskview}{task/view-answer-detail}',
                'buttons'=>[
                    'taskview'=>function ($url,$model,$key){
                    $task=Task::findOne(['task_guid'=>$model->task_guid]);
                    if(!empty($task))
                     return Html::a('任务详情 | ',['task/view','id'=>$task->id],['title'=>'任务详情']);
                    } ,
                    'task/view-answer-detail'=>function ($url,$model,$key){
                    return Html::a('任务结果  ',$url,['title'=>'任务详情']);
                    } ,
                ],
            ],
        ],
    ]); ?>
    </div>
</div>


            
