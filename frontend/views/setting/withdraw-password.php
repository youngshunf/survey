<?php

use yii\helpers\Html;

use common\models\CommonUtil;
use yii\helpers\Url;
use dosamigos\qrcode\QrCode;

/* @var $this yii\web\View */
/* @var $model backend\models\Enterprise */

$this->title = '支付密码管理';
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
   	                <li><a href="<?= yii::$app->urlManager->createUrl('profile/account')?>">我的银行卡</a></li>
   	                <li class="active"><a href="<?= yii::$app->urlManager->createUrl('profile/withdraw-password')?>">支付密码管理</a></li>
   	                </ul>
					</section>                                                                    	
                  </aside>
                  
                  <aside class="profile-info col-lg-9"> 
                  <section class="panel-white">
	                  	<div class="panel-white">
	                  	<h3>支付密码管理</h3>
	                       
	                     
	                    </div>
	                    <div class="row">
	                    <div class="col-md-2"></div>
	                   <div class="col-md-8">
	                   
	                   <?php if(empty($userArr['password_withdraw'])){?>
	                       <p>您还没有设置支付密码，请进行设置。支付密码在交易中使用，包括购买产品和提现</p>
	                   	                       
	                    <div class="set-password" id="set-password">
	                    <form action="<?= yii::$app->urlManager->createUrl('profile/set-withdraw-password')?>" method="post" onsubmit="return checkSetAll()">
	                               <div class="input-group">
                                 <span class="input-group-addon">请输入支付密码</span>
                                 <input type="password" class="form-control" name="password"  id="password" onblur="checkPassword(this.value)">
                                 <span id="password-error"></span>
                                 </div>
                                 <br>
                                 <div class="input-group">
                                 <span class="input-group-addon">请再次输入支付密码</span>
                                 <input type="password" class="form-control" name="password2"  id="password2" onblur="checkPassword2(this.value)">
                                 <span id="password2-error"></span>
                                 </div>
                                 <br>
                                  <p class="center"><button class="btn btn-success" type="submit">设置支付密码</button></p>
                            </form>
	                    </div>
	                    <?php }else{?>
	                     <p>您已经设置过支付密码,可进行支付密码修改。</p>
	                     <a class="btn btn-warning" id="do-change">修改支付密码</a>
	                     <a class="pull-right" href="<?= yii::$app->urlManager->createUrl('profile/apply-reset-withdraw-password')?>">忘记支付密码?</a>
	                     <p class="clear"></p>
	                    <div class="change-password hide"  id="change-password">
	                      <form action="<?= yii::$app->urlManager->createUrl('profile/change-withdraw-password')?>" method="post" onsubmit="return checkChangeAll()">
	                               <div class="input-group">
                                 <span class="input-group-addon">请输入原始支付密码</span>
                                 <input type="password" class="form-control" name="opassword"  id="opassword" onblur="checkOPassword(this.value)">
                                 <span id="opassword-error"></span>
                                 </div>
                                 <br>
	                               
	                               <div class="input-group">
                                 <span class="input-group-addon">请输入新支付密码</span>
                                 <input type="password" class="form-control" name="newpassword"  id="newpassword" onblur="checkNewPassword(this.value)">
                                 <span id="newpassword-error"></span>
                                 </div>
                                 <br>
                                 <div class="input-group">
                                 <span class="input-group-addon">请再次输入新支付密码</span>
                                 <input type="password" class="form-control" name="newpassword2"  id="newpassword2" onblur="checkNewPassword2(this.value)">
                                 <span id="newpassword2-error"></span>
                                 </div>
                                 <br>
                                  <p class="center"><button class="btn btn-success" type="submit">提交</button></p>
                            </form>
	                    
	                    </div>
	                     

	                       <?php }?>
	                    </div>
	                    <div class="col-md-2"></div>
	                     </div>
                  </section>
              
                  </aside>
              </div>

              <!-- page end-->
          </section>
      </section>




  <script>

  function setPassword(){
	   $("#set-password").removeClass('hide');
	  }
  function changePassword(){
	   $("#change-password").removeClass('hide');
	  }
	  
	   function checkPassword(value){
	       if(value==""){
	   	    $("#password-error").html("<font color='red'>x 支付密码不能为空</font>");
	   	    return false;
	       }else{
	    	   $("#password-error").html("");
	    	   return true;
	       }
	   }

	   function checkPassword2(value){
		   var pwd=$("#password").val();
		   if(value==""){
			   $("#password2-error").html("<font color='red'>x 确认密码不能为空</font>");
			   return false;
	       }else if(pwd!=value){
	    	   $("#password2-error").html("<font color='red'>x 两次密码不一致</font>");
			   return false;

	       }else{
	    	   $("#password2-error").html("");
	    	   return true;
	       }
	   }

	   function checkSetAll(){
		    var password=$("#password").val();
		    var password2=$("#password2").val();	
		    if(checkPassword(password)&&checkPassword2(password2)){
		        return true;
		    }else{
		        return false;
		    }
		    
	   }

	   function checkNewPassword(value){
	       if(value==""){
	   	    $("#newpassword-error").html("<font color='red'>x 密码不能为空</font>");
	   	    return false;
	       }else{
	    	   $("#newpassword-error").html("");
	    	   return true;
	       }
	   }

	   function checkNewPassword2(value){
		   var npwd=$("#newpassword2").val();
		   if(value==""){
			   $("#newpassword2-error").html("<font color='red'>x 确认密码不能为空</font>");
			   return false;
	       }else if(npwd!=value){
	    	   $("#newpassword2-error").html("<font color='red'>x 两次密码不一致</font>");
			   return false;

	       }else{
	    	   $("#newpassword2-error").html("");
	    	   return true;
	       }
	   }

	   function checkOPassword(value){
		   if(value==""){
			   $("#opassword-error").html("<font color='red'> x 原始密码不能为空</font>");
			   return false;
	       }else{
	    	   $("#opassword-error").html("");
	    	   return true;
	       }
	   }

	   function checkChangeAll(){
		   var opassword=$("#opassword").val();
		    var password=$("#newpassword").val();
		    var password2=$("#newpassword2").val();	
		    if(checkOPassword(opassword)&&checkNewPassword(password)&&checkNewPassword2(password2)){
		        return true;
		    }else{
		        return false;
		    }
		    
	   }

	   $("#do-change").click(function(){
		    $("#change-password").removeClass('hide');
		    $(this).addClass('hide');
	   });
                              	
  </script>
