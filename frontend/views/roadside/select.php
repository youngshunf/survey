<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Maintenance */

$this->title = '查看用户评价';
$this->params['breadcrumbs'][] = ['label' => '道路救援管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">
<!-- 
    <?php if (!empty($finalArr)) {
			foreach ($finalArr as $v){
		?>
		<div class="col-md-12 col-sm-12 content-margin20 border-expert">
		     <div class="renming">
		     	用户:<?php echo $v['user_guid']?>
				评价：<?php echo $v['content']?>
				星级:<?php echo $v['star']?>
				类型:<?php echo $v['type']?>
				<span class="pull-right"><?php echo CommonUtil::fomatHours($v['created_at'])?></span>
			</div>					
			<div class="line"></div>
			<?php if (!empty($v['reference'])) {
				foreach($v['reference'] as $r){
			?>
			<p>
			回复用户:<?php echo $r['user_guid']?>
			回复内容:<?php echo $r['content']?>
			回复时间:<?php echo CommonUtil::fomatHours($v['created_at'])?>
			</p>
			<?php }
			}?>		
		</div>	
		<?php }
		}?>
 -->
 
 		<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
 			'content',
//  			'type',
 			['attribute'=>'type','value'=>function ($model){
 				$type=$model->type;
 				return empty($type)?"":CommonUtil::getDescByValue('comment', 'type', $type);
 			}],
 			'star',
//  			'created_at',
//  			'updated_at',
            ['attribute'=>'created_at','value'=>function ($model){
            	$created_at=$model->created_at;
            	return empty($created_at)?"":CommonUtil::fomatDate($created_at);
//             	CommonUtil::getDescByValue('roadside', 'status', $status);
            }],
            ['attribute'=>'updated_at','value'=>function ($model){
            	$updated_at=$model->updated_at;
            	return empty($updated_at)?"":CommonUtil::fomatDate($updated_at);
            	//             	CommonUtil::getDescByValue('roadside', 'status', $status);
            }],

//             ['class' => 'yii\grid\ActionColumn',
//             'header'=>'操作',
//             'template'=>'{view}{update}{delete}',
//             'buttons'=>[
//             	'view'=>function ($url,$model,$key){
//             		return  Html::a('<button type="button" class="btn btn-primary">查看详情</button>', $url, ['title' => '查看详情'] );
//             	},
//             	'update'=>function ($url,$model,$key){
//             		if($model->status == CommonUtil::R_STATUS_0){
//             			return  Html::a('<button type="button" class="btn btn-success">确认救援</button>', $url, ['title' => '确认救援'] );
//             		}
//             	},
// 		        'delete'=>function ($url,$model,$key){
//             		if($model->status == CommonUtil::R_STATUS_0){
//             			return  Html::a('<button type="button" class="btn btn-danger">救援取消</button>', $url, ['title' => '救援取消'] );
//             		}
//             	},
//             	]
//             ],
        ],
    ]); ?>
 		
 
</div>
