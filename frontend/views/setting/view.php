<?php

use yii\helpers\Html;

use common\models\CommonUtil;
use yii\helpers\Url;
use dosamigos\qrcode\QrCode;

/* @var $this yii\web\View */
/* @var $model backend\models\Enterprise */

$this->title = '个人信息';
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
   	                <li><a href="<?= yii::$app->urlManager->createUrl('profile/withdraw-password')?>">支付密码管理</a></li>
   	                </ul>
					</section>                                                                    	
                  </aside>
                  
                  <aside class="profile-info col-lg-9"> 
                  <section class="panel">
	                  	<div class="panel-body bio-graph-info ">
	                              
            <DIV style="font-family: 'Microsoft YaHei', Helvetica, Arial, sans-serif; font-size: 24px;color:#4CC5CD;"> 邀请码:<?php echo $userArr["invite_code"]?></DIV>
	  
	       <p class="invite-link">  <span>邀请注册连接</span>&nbsp;&nbsp;&nbsp;<a href="<?=yii::$app->urlManager->createAbsoluteUrl('site/register')."?invite_code=". $userArr["invite_code"]?>"><?=yii::$app->urlManager->createAbsoluteUrl('site/register')."?invite_code=". $userArr["invite_code"]?></a></span>   </p>                                            
	         <p class="invite-link"><span>邀请注册二维码</span></p>
	        <p class="invite-qrcode">
	          <img src="<?=yii::getAlias('@upload')?>/qrcode/<?= $userArr['user_guid']?>.png" class="img-responsvie ">
	        </p>
	                    </div>
                  </section>
                  <section class="panel">
                          <div class="panel-body">
                              <p class="text-muted">
                                 目前您的级别:<?php echo CommonUtil::getDescByValue('user', 'rank', $userArr->rank);?>
                              </p>
                              <div class="progress progress-striped active progress-sm" 
      data-container="body" data-toggle="popover" data-placement="bottom" 
      data-content="目前您的级别:<?php echo CommonUtil::getDescByValue('user', 'rank', $userArr->rank);?>">
                                  <?php if($userArr->rank>0){?>
                                  <div class="progress-bar progress-bar-success" style="width: 16%">
                                      <span class="sr-only">35% Complete (success)</span>
                                  </div>
                                  	<?php if ($userArr->rank>1){?>
                                  <div class="progress-bar progress-bar-warning" style="width: 16%">
                                      <span class="sr-only">20% Complete (warning)</span>
                                  </div>
                                  		<?php if ($userArr->rank>2){?>
                                  <div class="progress-bar progress-bar-danger" style="width: 17%">
                                      <span class="sr-only">10% Complete (danger)</span>
                                  </div>
                                  			<?php if ($userArr->rank>3){?>
                                  <div class="progress-bar" style="width: 17%">
                                      <span class="sr-only">35% Complete (success)</span>
                                  </div>
                                  				<?php if ($userArr->rank>4){?>
                                  <div class="progress-bar progress-bar-info" style="width: 17%">
                                      <span class="sr-only">20% Complete (warning)</span>
                                  </div>
                                  					<?php if ($userArr->rank>5){?>
                                  <div class="progress-bar progress-bar-danger" style="width: 17%">
                                      <span class="sr-only">10% Complete (danger)</span>
                                  </div>
                                  						<?php if ($userArr->rank>6){?>
                                  <div class="progress-bar progress-bar-danger" style="width: 17%">
                                      <span class="sr-only">10% Complete (danger)</span>
                                  </div>
                                  <?php                      }             				
														}
													}
												}
											}
										}
									}
									?>
                              </div>
                          </div>
                      </section>

                      <section class="panel">

                          <div class="panel-body bio-graph-info">
                              <h1>个人信息</h1>
                              <div class="row">
                                  <div class="bio-row">
                                      <p><span>用户名</span> <?php echo $userArr->username;?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>姓名 </span> <?php echo $userArr->real_name;?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>昵称 </span> <?php echo $userArr->nick;?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>性别</span> <?php echo CommonUtil::getDescByValue('user', 'gender', $userArr->gender);?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>身份证号码 </span> <?php echo $userArr->ID_code;?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>电话 </span> <?php echo $userArr->mobile;?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>邮箱 </span> <?php echo $userArr->email;?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>状态 </span> <?php echo CommonUtil::getDescByValue('user', 'status', $userArr->status);?></p>
                                  </div>
                              </div>
                          </div>
                      </section>
                   <!--    <section>
                          <div class="row">
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="35" data-fgColor="#e06b7d" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="red">获得奖励次数</h4>
                                              <p>获得奖励次数 : 35 次</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="5" data-fgColor="#4CC5CD" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="terques">获得车奖房奖次数</h4>
                                              <p>获得车奖房奖次数 : 5 次</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="75" data-fgColor="#96be4b" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="green">月登录比例</h4>
                                              <p>登录天数 : 22 天</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="50" data-fgColor="#cba4db" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="purple">年登录比例</h4>
                                              <p>登录天数 : 182 天</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </section> -->
                  </aside>
              </div>

              <!-- page end-->
          </section>
      </section>




  <script>

      //knob
  $(document).ready(function() {
      $(".knob").knob();
      $(function(){
          $("[data-toggle='popover']").popover();
      });
  });
  $("#submit").click(function(){
	    return $("#img_path").click();
  });
  $("#img_path").change(function(){
	  return $("#upload").click();
  });
  </script>
