<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchComment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户评价管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<!-- 
    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'order.orderno',
    		['attribute'=>'type','value'=>function ($model){
    			$type=$model->type;
    			return empty($type)?"":CommonUtil::getDescByValue('comment', 'type', $type);
    		}],
    		'score',
    		'content',
			['attribute'=>'created_at','value'=>function ($model){
				$created_at=$model->created_at;
				return empty($created_at)?"":CommonUtil::fomatDate($created_at);
			}],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
