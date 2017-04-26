<?php 

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
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
        <p class="login-box-msg">注册</p>
          <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['placeholder'=>'用户名'])->label('用户名') ?>
                <?= $form->field($model, 'email')->textInput(['placeholder'=>'邮箱'])->label('邮箱') ?>
                <?= $form->field($model, 'mobile')->textInput(['placeholder'=>'手机号'])->label('手机号') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>
                <?= $form->field($model, 'password2')->passwordInput()->label('确认密码') ?>
                 <p><a class="pull-right" href="<?= Url::to(['login'])?>">登录</a></p>
                 <p class="clear"></p>
                <div class="form-group text-center">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
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
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
