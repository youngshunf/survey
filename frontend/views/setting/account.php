<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model backend\models\Enterprise */

$this->title = '我的银行卡';
$this->params['breadcrumbs'][] = ['label' => '个人中心', 'url' => ['/profile/view']];
$this->params['breadcrumbs'][] = $this->title;

?>

<section id="container" class="">

          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                             <!--  <a href="#">
								<?php if(empty($userArr["img_path"])){?>                              
                                  <img src="<?php echo Yii::getAlias("@avatar");?>/unknown.jpg" alt="">
                              	<?php }else{?>
                              	  <img src="<?php echo Yii::getAlias("@avatar");?>/<?php echo $userArr["img_path"]?>" alt="">
                              	<?php }?>
                              </a> -->
                              <h1><?php echo empty($userArr['real_name'])?"":$userArr['real_name'];?></h1>
                              <p><?php echo empty($userArr['email'])?"":$userArr['email'];?></p>
                          </div>
                          <div class="profile-modify">
                         <!--   <form action="<?= yii::$app->urlManager->createUrl('profile/update_img')?>" method="post" enctype="multipart/form-data"> 
                          <input type="file"  name="img_path" class="hidden"  id="img_path">
                           <input type="text"  name="user_guid"  value="<?= $userArr['user_guid']?>" class="hidden">
                          <button class="hidden"  type="submit"  id="upload"></button>
                          </form>                       
                            <a class="btn btn-primary"  id="submit" >修改头像</a>-->
                            <a class="btn btn-primary" href="<?= yii::$app->urlManager->createUrl('profile/change-password')?>">修改密码</a>
                            <?= Html::a('修改信息', ['update', 'id' => $userArr->id], ['class' => 'btn btn-primary']) ?>                      
                          </div>
   	
   	                <ul class="nav nav-pills nav-stacked">
   	                <li class="active"><a href="<?= yii::$app->urlManager->createUrl('profile/account')?>">我的银行卡</a></li>
   	                <li><a href="<?= yii::$app->urlManager->createUrl('profile/withdraw-password')?>">支付密码管理</a></li>
   	                </ul>
					</section>                                                                    	
                  </aside>
                  
                  <aside class="profile-info col-lg-9"> 
                  <section class="panel">
	                  	<div class="panel-body bio-graph-info ">
	                       
	                       <h3>我的银行卡</h3>
                            <?= GridView::widget([
                                'dataProvider' => $accountData,
                                'columns' => [
                                ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
                                   'bank',
                                   'account',
                                   'create_account_bank',
                                   'name',
                                   ['attribute'=>'状态','value'=>function($model){
                                    return CommonUtil::getAccountStatus($model->status);
                                }],
                                ['attribute'=>'时间','value'=>function($model){
                                    return CommonUtil::fomatTime($model->insert_time);
                                }]
                                ],
                            ]); ?>
								<p><a class="btn btn-warning pull-right"  href="javascript:void(0)" onclick="newAccount()" >新增银行卡</a></p>	
								  <br>
                            <div class="clear"></div>
                            <div class="new-account  hide" id="new-account">
                            <form action="<?= yii::$app->urlManager->createUrl('profile/new-account')?>" method="post" onsubmit="return checkAll()">
                                 <input type="hidden" name="accountToken" value="<?=$token?>">
                                 <div class="input-group">
                                 <span class="input-group-addon">开户银行</span>
                                 <input type="text" class="form-control" name="bank"  id="bank" onblur="checkBank(this.value)">
                                 <span id="bank-error"></span>
                                 </div>
                                 <br>
                                   <div class="input-group">
                                 <span class="input-group-addon">支行信息</span>
                                 <input type="text" class="form-control" name="create_bank"  id="create_bank" onblur="checkCreate(this.value)">
                                 <span id="create-error"></span>
                                 </div>
                                 <br>
                                  <div class="input-group">
                                 <span class="input-group-addon">开户账号</span>
                                 <input type="text" class="form-control" name="account" id="account" onblur="checkAccount(this.value)">
                                 <span id="account-error"></span>
                                 </div>
                                  <br>
                                  <div class="input-group">
                                 <span class="input-group-addon">确认账号</span>
                                 <input type="text" class="form-control" name="sec-account" id="sec-account" onblur="checkSecAccount(this.value)">
                                 <span id="sec-account-error"></span>
                                 </div>
                                  <br>
                                  <div class="input-group">
                                 <span class="input-group-addon">开户姓名</span>
                                 <input type="text" class="form-control" name="name" id="name" onblur="checkName(this.value)">
                                  <span id="name-error"></span>
                                 </div>
                                  <br>
                                <p class="center"><button class="btn btn-success" type="submit">提交</button></p>
                            </form>
                            </div>
                            
                          </div>
                      </section>

                 
                        
                  </aside>
              </div>

          </section>
      </section>




  <script>
  function newAccount(){
   $("#new-account").removeClass('hide');

  }

  
   function checkBank(value){
       if(value==""){
   	    $("#bank-error").html("<font color='red'>x 银行不能为空</font>");
   	    return false;
       }else{
    	   $("#bank-error").html("");
    	   return true;
       }
   }

   function checkCreate(value){
       if(value==""){
   	    $("#create-error").html("<font color='red'>x 开户行不能为空</font>");
   	    return false;
       }else{
    	   $("#create-error").html("");
    	   return true;
       }
   }
   function checkAccount(value){
	   if(value==""){
		   $("#account-error").html("<font color='red'>x 银行账号不能为空</font>");
		   return false;
       }else{
    	   $("#account-error").html("");
    	   return true;
       }
   }

   function checkSecAccount(value){
	
	   var account=$("#account").val();
	   if(value==""){
		   $("#sec-account-error").html("<font color='red'>x 确认账号不能为空</font>");
		   return false;
       }else if(account!=value){          
    	  $("#sec-account-error").html("<font color='red'>x 两次输入账号不一致,请重新输入</font>");
		   return false;
      }else{      
    	   $("#sec-account-error").html("");
    	   return true;
      }
   }

   function checkName(value){
	   if(value==""){
		   $("#name-error").html("<font color='red'> x 姓名不能为空</font>");
		   return false;
       }else{
    	   $("#name-error").html("");
    	   return true;
       }
   }

   function checkAll(){
	    var bank=$("#bank").val();
	    var account=$("#account").val();
	    var name=$("#name").val();
	    var create=$("#create_bank").val()
	    var secAccount=$("#sec-account").val();
	    if(checkBank(bank)&&checkAccount(account)&&checkName(name)&&checkCreate(create)&&checkSecAccount(secAccount)){
	        return true;
	    }else{
	        return false;
	    }
	    

   }


  </script>
