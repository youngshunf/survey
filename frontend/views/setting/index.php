<?php

use yii\helpers\Html;

use common\models\CommonUtil;
use yii\helpers\Url;
use dosamigos\qrcode\QrCode;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Enterprise */

$this->title = '设置';
$this->params['breadcrumbs'][] = $this->title;

?>

<section id="container" class="">

          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                               <a href="#">
								<?php if(empty($userArr["img_path"])){?>                              
                                  <img src="<?php echo Yii::getAlias("@avatar");?>/unknown.jpg" alt="">
                              	<?php }else{?>
                              	  <img src="<?php echo Yii::getAlias("@avatar");?>/<?php echo $userArr["img_path"]?>" alt="">
                              	<?php }?>
                              </a>
                              <h1><?php echo empty($userArr['username'])?"":$userArr['username'];?></h1>
                              <p><?php echo empty($userArr['email'])?"":$userArr['email'];?></p>
                          </div>
                          <div class="profile-modify">
                        <form action="<?= yii::$app->urlManager->createUrl('profile/update_img')?>" method="post" enctype="multipart/form-data"> 
                          <input type="file"  name="img_path" class="hidden"  id="img_path">
                           <input type="text"  name="user_guid"  value="<?= $userArr['user_guid']?>" class="hidden">
                          <button class="hidden"  type="submit"  id="upload"></button>
                          </form>                       
                            <a class="btn btn-primary"  id="submit" >修改头像</a>                                             
                          </div>
                          <p class="center"> <a class="btn btn-info" href="<?= yii::$app->urlManager->createUrl('profile/change-password')?>">修改密码</a>
                            <?= Html::a('修改信息', ['update', 'id' => $userArr->id], ['class' => 'btn btn-warning']) ?>  </p>
                              	
   	                <ul class="nav nav-pills nav-stacked">
   	            
   	                <li><a href=""></a></li>
   	            
   	                </ul>
					</section>                                                                    	
                  </aside>
                  
                  <aside class="profile-info col-lg-9"> 
                      <section class="panel">

                          <div class="panel-body bio-graph-info">
                              <h1>账户信息</h1>
                              <div class="row">
                                  <div class="bio-row">
                                      <p><span>用户名</span> <?php echo $userArr->username;?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>邮箱 </span> <?php echo $userArr->email;?></p>
                                  </div>
                           
                                  
                                  <div class="bio-row">
                                      <p><span>电话 </span> <?php echo $userArr->mobile;?></p>
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
