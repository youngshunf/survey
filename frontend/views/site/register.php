<?php 

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>随心赚商户后台 | 注册</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?= yii::getAlias('@web')?>/AdminLTE/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
 
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= yii::getAlias('@web')?>/AdminLTE/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= yii::getAlias('@web')?>/AdminLTE/plugins/iCheck/square/blue.css">
     <link rel="stylesheet" href="<?= yii::getAlias('@web')?>/css/common.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo text-center">
      <img alt="" src="<?= yii::getAlias('@web')?>/img/logo.png" class=" main-logo">
        <p class='main-blue' ><b class='main-orange'>随心赚</b></p>
        商户后台
      </div><!-- /.login-logo -->
      <div class="login-box-body">
       <?= Alert::widget() ?>
          <?php $form = ActiveForm::begin(['id' => 'register-form','options' => ['onsubmit'=>'return check()']]); ?>
                <?= $form->field($model, 'username')->textInput(['placeholder'=>'用户名'])->label('用户名') ?>
                <?= $form->field($model, 'email')->textInput(['placeholder'=>'邮箱'])->label('邮箱') ?>
                <?= $form->field($model, 'mobile')->textInput(['placeholder'=>'手机号'])->label('手机号') ?>
                
                 <label>验证码</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="verify_code" id="verify-code">
                  <span class="input-group-addon" placeholder="请输入验证码" style="cursor:pointer" id="sendCode">发送验证码</span>
                </div>
                <p class="hide" style="color:green" id="code-tip">验证码已发送,请注意查收</p>
                <br>
                
                <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>
                <?= $form->field($model, 'password2')->passwordInput()->label('确认密码') ?>
                 <p><a class="pull-right" href="<?= Url::to(['login'])?>">登录</a></p>
                 <p class="clear"></p>
                <div class="form-group text-center">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-block btn-primary', 'name' => 'login-button']) ?>
                </div>
               
            <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center">
         
     
        </div><!-- /.social-auth-links -->

    

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?= yii::getAlias('@web')?>/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?= yii::getAlias('@web')?>/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?= yii::getAlias('@web')?>/AdminLTE/plugins/iCheck/icheck.min.js"></script>
    <script>
	 var isSend=0;
      function sendVerifyCode(mobile){
    	  $('#code-tip').addClass('hide');
			$.ajax({
				url:'<?= Url::to('send-verify-code')?>',
				method:'post',
				data:{
					mobile:mobile
				},
				dataType:'json',
				success:function(res){
					console.log(res);
					if(res.result=='success'){
						$('#code-tip').html('验证码已发送,请注意查收!');
						$('#code-tip').css('color','green');
						$('#code-tip').removeClass('hide');
						isSend=1;
						var count=120;
						$('#sendCode').html(count+'s');
						var timer=setInterval(function(){
							if(count>0){
								count--;
								$('#sendCode').html(count+'s');
							}else{
								isSend=0;
								$('#sendCode').html('发送验证码');
								clearInterval(timer);
							}
						},1000);
					}else{
						if(res.errcode=='e1004'){
							$('#code-tip').html('账号已存在,直接登录!');
							$('#code-tip').css('color','red');
							$('#code-tip').removeClass('hide');
						}
						
					}
					
					
				},
				error:function(e){
					console.log(e);
					$('#code-tip').html('验证码发送失败,请重试!');
					$('#code-tip').css('color','red');
					$('#code-tip').removeClass('hide');
				}
			})
      }

      $('#sendCode').click(function(){
           if(isSend==1){
			return false;
           }
           
			var mobile=$("#registerform-mobile").val();
			if(!mobile){
				$('#code-tip').html('请输入手机号!');
				$('#code-tip').css('color','red');
				$('#code-tip').removeClass('hide');
				return false;
			}
			sendVerifyCode(mobile);
          });
      function check(){
			var code=$('#verify-code').val();
			if(!code){
				$('#code-tip').html('验证码不能为空');
				$('#code-tip').css('color','red');
				$('#code-tip').removeClass('hide');
				return false;
			}

			return true;
      }
    </script>
  </body>
</html>
