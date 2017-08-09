<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\AnswerDetail;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = '任务结果详情-'.$model->task->name;
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/mui.min.css');
$role_id=yii::$app->user->identity->role_id;
?>
<style>
p{
	color:#000;
}

</style>
 <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">任务结果详情</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php if($role_id==99||$role_id==98){?>
                <button class="btn btn-success" id="first-auth">一审</button>
                  <button class="btn btn-info" id="sec-auth">二审</button>
                <?php }elseif ( $role_id==97){?>
                   <button class="btn btn-success" id="first-auth">一审</button>
                <?php }elseif ($role_id==96){?>
                     <button class="btn btn-info" id="sec-auth">二审</button>
                <?php }?>
                <a class="btn btn-warning" href="<?= Url::to(['view-answer-auth','id'=>$model->id])?>">查看审核结果</a>
        <a class="btn btn-success" href="javascript:;" onclick="history.go(-1)">返回</a>
        <?php foreach ($question as $k=>$v){?>    
        <ul class="mui-table-view" >
				<li class="mui-table-view-cell">
					<p class="bold">
				<?= $k+1?>、	<?= $v['name']?> （<?= CommonUtil::getDescByValue('question', 'type', $v['type'])?>） 
					</p>
					
				</li>
				<li class="mui-table-view-cell">
				<?php if ($v['type']==0){
				    $answerArr=AnswerDetail::findOne(['answer_guid'=>$model->answer_guid, 'question_guid'=>$v['question_guid'],'user_guid'=>$model->user_guid]);
                    if(!empty($answerArr)){
				    $answer=explode(':', $answerArr['answer']);
				    ?>
				<p>答案: 选项<?=$answer[0]=1?>、<?= $answer[1]?>
				<?php if(!empty($answerArr->open_answer)){?>
				;<?= $answerArr->open_answer ?>
				<?php }?>
				</p>
				<?php }else{?>
				<p>未作答</p>
				  <?php }?>
				<?php }elseif ($v['type']==1){
				    $answerArr=AnswerDetail::findOne(['answer_guid'=>$model->answer_guid, 'question_guid'=>$v['question_guid'],'user_guid'=>$model->user_guid]);
				
				    if(!empty($answerArr)){
				    $answer=json_decode($answerArr['answer'],true);
				   foreach ($answer as $item){
				    $an=explode(':', $item);
				    ?>
				    <p>答案: 选项<?=$an[0]+1?>、<?= $an[1]?></p>
				    <?php } }else{?>
				    <p>未作答</p>
				    <?php }?>
				
				<?php }elseif ($v['type']==2 || $v['type']==4 ||  $v['type']==6 ||$v['type']==7){
				    $answerArr=AnswerDetail::findOne(['answer_guid'=>$model->answer_guid, 'question_guid'=>$v['question_guid'],'user_guid'=>$model->user_guid]);
				    ?>
				   <?php  if ($v['type']==4){?>
				<p>答案: <a href="<?= yii::getAlias('@photo').'/'.$answerArr['path'].$answerArr['photo']?>">下载</a></p>
				<?php }else{?>
				<p>答案: <?= @$answerArr['answer']?></p>
				<?php }?>
				
				<?php }elseif ($v['type']==3){
				$answerArr=AnswerDetail::find()->andWhere(['answer_guid'=>$model->answer_guid,'task_guid'=>$v['task_guid'],'user_guid'=>$model->user_guid, 'question_guid'=>$v['question_guid']])->orderBy('answer')->all();
                    foreach ($answerArr as $answer){
				?>
				<div class="col-md-3 answer-img">
				<a href="<?= yii::getAlias('@photo').'/'.$answer['path'].$answer['photo']?>" target="_blank" ><img alt="" src="<?= yii::getAlias('@photo').'/'.$answer['path'].'thumb/'.$answer['photo']?>" class="img-responsive">
                </a>
                </div>
				
				<?php }?>
				<?php } ?>
				</li>
				</ul>
        <?php }?>
    
</div>
</div>

  <div class="modal fade" id="firstAuthModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              一审
            </h4>
         </div>
         <div class="modal-body">            	
            <form action="<?=Url::to(['first-auth'])?>" method="post" id="option-form" onsubmit="return checkFirst()">
           <input type="hidden" name="answer_id" value="<?= $model->id?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
          <div class="form-group">
              <label class="label-control">审核结果</label>
              <select name="first-auth" id="first-auth">
              <option value="1">合格</option>
              <option value="99">不合格</option>
              </select>
            </div>
            
            <div class="form-group">
                <label class="label-control">审核意见</label>
               <textarea rows="3"  name="first-auth-remark" id="first-auth-remark" class="form-control"></textarea>
            </div>
            
                <p class="center"><button type="submit" class="btn btn-info">提交</button></p>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
</div><!-- /.modal -->
		
	<div class="modal fade" id="secAuthModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              二审
            </h4>
         </div>
         <div class="modal-body">       
         <?php if($model->first_auth==0){?>     	
         <p class="red">请等待一审结束再来进行二审!</p>
         <?php }else{?>
         <ul class="mui-table-view">
         <li class="mui-table-view-cell">
         <p>一审结果:<?= CommonUtil::getDescByValue('answer', 'first_auth', $model->first_auth)?></p>
         </li>
          <li class="mui-table-view-cell">
         <p>一审意见 :<?=  $model->first_auth_remark?></p>
         </li>
         </ul>
            <form action="<?=Url::to(['sec-auth'])?>" method="post" id="option-form" onsubmit="return checkSec()">
           <input type="hidden" name="answer_id" value="<?= $model->id?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
          <div class="form-group">
              <label class="label-control">审核结果</label>
              <select name="sec-auth" id="sec-authpanel">
              <option value="1">25%合格</option>
                  <option value="2">50%合格</option>
                  <option value="3">75%合格</option>
                  <option value="4">合格</option>
                 <option value="99">不合格</option>
                  <option value="98">其他</option>
              </select>
              <input type="number" class="form-control hide" name="other" placeholder="请输入合格率,1-99">
            </div>
            
            <div class="form-group">
                <label class="label-control">审核意见</label>
               <textarea rows="3"  name="sec-auth-remark" id="sec-auth-remark" class="form-control"></textarea>
            </div>
            
                <p class="center"><button type="submit" class="btn btn-info">提交</button></p>
            </form>
            <?php }?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
</div><!-- /.modal -->
		
<script>
$('#first-auth').click(function(){
$('#firstAuthModal').modal('show');
});

$('#sec-auth').click(function(){
	$('#secAuthModal').modal('show');
});

$('#sec-authpanel').change(function () {
   var res=$(this).val();

    if(res==98){
        $('input[name=other]').removeClass('hide');

    }else{
        $('input[name=other]').addClass('hide');
    }
});

function checkFirst(){
	if($('#first-auth').val()==99){
	    if(!$('#first-auth-remark').val()){
	        modalMsg('请填写审核意见!');
	        return false;
	    }
	}

	showWaiting('正在提交,请稍候...');
	return true;
}

function checkSec(){
	if($('#sec-authpanel').val()==99){
	    if(!$('#sec-auth-remark').val()){
	        modalMsg('请填写审核意见!');
	        return false;
	    }
	}
    if($('#sec-authpanel').val()==98){
        if(!$('input[name=other]').val()){
            modalMsg('请填写审核合格率!');
            return false;
        }
        var other=$('input[name=other]').val();
        if(other<=0 || other>=100){
            modalMsg('合格率请输入1-99之间的数字!');
            return false;
        }
    }
	showWaiting('正在提交,请稍候...');
	return true;
}
				</script>