<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\AnswerDetail;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = '任务结果详情';
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/mui.min.css');
?>

 <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">任务结果详情</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
        <?php foreach ($answerDetail as $k=>$v){?>    
        <ul class="mui-table-view" >
				
				<li class="mui-table-view-cell">
					<p class="bold">
				<?= $k+1?>、	<?= $v['question']['name']?> （<?= CommonUtil::getDescByValue('question', 'type', $v['question']['type'])?>） 
					</p>
											
					
				</li>
				<li class="mui-table-view-cell">
				<?php if ($v['type']==0){
				    $answer=explode(':', $v['answer']);
				    ?>
				<p>答案: 选项<?=$answer[0]=1?>、<?= $answer[1]?></p>
				<?php }elseif ($v['type']==1){
				$answer=json_decode($v['answer'],true);
				foreach ($answer as $item){
				    $an=explode(':', $item);
				    ?>
				    <p>答案: 选项<?=$an[0]=1?>、<?= $an[1]?></p>
				    <?php }?>
				
				<?php }elseif ($v['type']==2){?>
				<p>答案: <?= $v['answer']?></p>
				
				<?php }elseif ($v['type']==3){
				$answerArr=AnswerDetail::find()->andWhere(['task_guid'=>$v['task_guid'],'user_guid'=>$v['user_guid'], 'question_guid'=>$v['question_guid']])->orderBy('answer')->all();
                    foreach ($answerArr as $answer){
				?>
				<div class="col-md-4">
				<img alt="" src="<?= yii::getAlias('@photo').'/'.$answer['path'].$answer['photo']?>" class="img-responsive">
				</div>
				
				<?php }?>
				<?php }?>
				</li>
				</ul>
        <?php }?>
    
</div>
</div>

