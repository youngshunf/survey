<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\AnswerDetail;


$this->title = $answer->task->name.'-任务审核详情';
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
                  <h3 class="box-title">任务审核详情</h3>
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
        <ul class="mui-table-view" >
				<li class="mui-table-view-cell">
					<p class="bold">
				    一审
					</p>
				</li>
				<li class="mui-table-view-cell">
					<p><span class="bold">
				    一审结果 :</span>
				 <span class="red">   <?= CommonUtil::getDescByValue('answer', 'first_auth', $answer->first_auth)?></span></p>
				    <p><span class="bold">
				    一审意见 :</span>
				    <?=  $answer->first_auth_remark?></p>
				</li>
				<li class="mui-table-view-cell">
					<p class="bold">
				    二审
					</p>
				</li>
					<li class="mui-table-view-cell">
					<p><span class="bold">
				    二审结果 :</span>
				   <span class="red"> <?= CommonUtil::getDescByValue('answer', 'second_auth', $answer->second_auth)?></span></p>
				    <p><span class="bold">
				    二审意见 :</span>
				    <?=  $answer->second_auth_remark?></p>
				</li>
				</ul>
				<br>
    <p class="center">
        <a class="btn btn-success" href="javascript:;" onclick="history.go(-1)">返回</a>
    </p>
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
           <input type="hidden" name="answer_id" value="<?= $answer->id?>">
              <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
          <div class="form-group">
              <label class="label-control">审核结果</label>
              <select name="first-auth" id="first-auth"  value="<?= $answer->first_auth?>">
              <option value="1">合格</option>
              <option value="99">不合格</option>
              </select>
            </div>
            
            <div class="form-group">
                <label class="label-control">审核意见</label>
               <textarea rows="3"  name="first-auth-remark" id="first-auth-remark" class="form-control" value="<?= $answer->first_auth_remark?>"></textarea>
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
         <?php if($answer->first_auth==0){?>     	
         <p class="red">请等待一审结束再来进行二审!</p>
         <?php }else{?>
         <ul class="mui-table-view">
         <li class="mui-table-view-cell">
         <p>一审结果:<?= CommonUtil::getDescByValue('answer', 'first_auth', $answer->first_auth)?></p>
         </li>
          <li class="mui-table-view-cell">
         <p>一审意见 :<?=  $answer->first_auth_remark?></p>
         </li>
         </ul>
            <form action="<?=Url::to(['sec-auth'])?>" method="post" id="option-form" onsubmit="return checkSec()">
           <input type="hidden" name="answer_id" value="<?= $answer->id?>">
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
               <textarea rows="3"  name="sec-auth-remark" id="sec-auth-remark" class="form-control"  value="<?= $answer->second_auth_remark?>"></textarea>
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