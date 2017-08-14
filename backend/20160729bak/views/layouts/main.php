<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\assets\AdminAsset;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
$this->registerCssFile('@web/css/common.css');
$this->registerCssFile('@web/css/site.css');
$this->registerJsFile('@web/js/common.js');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
       <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="<?= Url::to(['site/index'])?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>赚</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">随心<b>赚</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-danger">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">您有4条未读消息</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                            <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="img-circle" alt="头像">
                          </div>
                          <h4>
                           用户下单
                            <small><i class="fa fa-clock-o"></i> 5 分钟前</small>
                          </h4>
                          <p>您有一个新的订单,请尽快处理</p>
                        </a>
                      </li><!-- end message -->
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="img-circle" alt="User Image">
                          </div>
                          <h4>
                           用户下单
                            <small><i class="fa fa-clock-o"></i> 5 分钟前</small>
                          </h4>
                          <p>您有一个新的订单,请尽快处理</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="img-circle" alt="User Image">
                          </div>
                            <h4>
                           用户下单
                            <small><i class="fa fa-clock-o"></i> 5 分钟前</small>
                          </h4>
                          <p>您有一个新的订单,请尽快处理</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="img-circle" alt="User Image">
                          </div>
                           <h4>
                           用户下单
                            <small><i class="fa fa-clock-o"></i> 5 分钟前</small>
                          </h4>
                          <p>您有一个新的订单,请尽快处理</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="img-circle" alt="User Image">
                          </div>
                             <h4>
                           用户下单
                            <small><i class="fa fa-clock-o"></i> 5 分钟前</small>
                          </h4>
                          <p>您有一个新的订单,请尽快处理</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">查看所有消息</a></li>
                </ul>
              </li>
    

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="user-image" alt="User Image">
                  <span class="hidden-xs"><?= yii::$app->user->identity->username?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="img-circle" alt="User Image">
                    <p>
                    <?= yii::$app->user->identity->username?>
                      <small><?= date("Y-m-d")?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <?php if(yii::$app->user->identity->role_id==99){?>
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="<?= Url::to(['user/index'])?>">用户</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="<?= Url::to(['task/index'])?>">任务</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="<?= Url::to(['finance/index'])?>">财务</a>
                    </div>
                  </li>
                  <?php }?>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat"></a>
                    </div>
                    <div class="pull-right">
                       <?= Html::a('注销', ['site/logout'], [
                                    'class'=>'btn btn-default btn-flat',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]) ?>

                    </div>
                  </li>
                </ul>
              </li>
           
            </ul>
          </div>
        </nav>
      </header>
      
       <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=yii::getAlias('@avatar')?>/unknown.jpg" class="img-circle" alt="头像">
            </div>
            <div class="pull-left info">
              <p><?= yii::$app->user->identity->username?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
          </div>
      
    
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="<?php if(yii::$app->controller->id=='site'&&yii::$app->controller->action->id=='index') echo "active";?> treeview">
              <a href="<?= Url::to(['site/index'])?>">
                <i class="fa fa-dashboard"></i> <span>首页</span>
              </a>          
            </li>
            <?php if(yii::$app->user->identity->role_id==99){?>
            <li class="<?php if(yii::$app->controller->id=='user') echo "active";?> treeview">
              <a href="#">
                <i class="fa fa-user"></i>
                <span>用户管理</span>
               <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?php if(yii::$app->controller->id=='user'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['user/index'])?>"><i class="fa fa-circle-o"></i> 会员管理</a></li>
                   <li class="<?php if(yii::$app->controller->id=='user'&&yii::$app->controller->action->id=='group') echo "active";?>" ><a href="<?= Url::to(['user/group'])?>"><i class="fa fa-circle-o"></i> 用户分组</a></li>
                <li class="<?php if(yii::$app->controller->id=='admin-user') echo "active";?>" ><a href="<?= Url::to(['admin-user/index'])?>"><i class="fa fa-circle-o"></i> 平台管理员</a></li>
                <li class="<?php if(yii::$app->controller->id=='admin-user'&&yii::$app->controller->action->id=='sp-user') echo "active";?>" ><a href="<?= Url::to(['admin-user/sp-user'])?>"><i class="fa fa-circle-o"></i> 第三方管理员</a></li>
              </ul>
            </li>
            <?php }?>
            
            <li class="<?php if(yii::$app->controller->id=='task'||yii::$app->controller->id=='template' ) echo "active";?> treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>任务管理</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li  class="<?php if(yii::$app->controller->id=='task'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['task/index'])?>"><i class="fa fa-circle-o"></i> 全部任务</a></li>
                <li class="<?php if(yii::$app->controller->id=='task'&&yii::$app->controller->action->id=='admin-task') echo "active";?>" ><a href="<?= Url::to(['task/admin-task'])?>"><i class="fa fa-circle-o"></i> 平台任务</a></li>
                 <?php if(yii::$app->user->identity->role_id==99){?>
                <li class=" <?php if(yii::$app->controller->id=='task'&&yii::$app->controller->action->id=='sp-task') echo "active";?>" ><a href="<?= Url::to(['task/sp-task'])?>"><i class="fa fa-circle-o"></i> 第三方任务</a></li>
                <li  class="<?php if(yii::$app->controller->id=='template'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['template/index'])?>"><i class="fa fa-circle-o"></i> 问卷模板</a></li>
               <li  class="<?php if(yii::$app->controller->id=='template'&&yii::$app->controller->action->id=='task') echo "active";?>" ><a href="<?= Url::to(['template/task'])?>"><i class="fa fa-circle-o"></i> 任务模板</a></li>
                <li  class="<?php if(yii::$app->controller->id=='project') echo "active";?>" ><a href="<?= Url::to(['project/index'])?>"><i class="fa fa-circle-o"></i>项目管理</a></li>
                <?php }?>
               
              </ul>
            </li>
            <?php if(yii::$app->user->identity->role_id==99){?>
            <li class="<?php if(yii::$app->controller->id=='finance') echo "active";?> treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>财务管理</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li class="<?php if(yii::$app->controller->id=='finance'&&yii::$app->controller->action->id=='index') echo "active";?>"><a href="<?= Url::to(['finance/index'])?>"><i class="fa fa-circle-o"></i> 平台财务</a></li>
                <li class="<?php if(yii::$app->controller->id=='finance'&&yii::$app->controller->action->id=='member') echo "active";?>" ><a href="<?= Url::to(['finance/member'])?>"><i class="fa fa-circle-o"></i> 会员财务</a></li>
                <li class="<?php if(yii::$app->controller->id=='finance'&&yii::$app->controller->action->id=='sp-finance') echo "active";?>"><a href="<?= Url::to(['finance/sp-finance'])?>"><i class="fa fa-circle-o"></i> 第三方财务</a></li>
               
              </ul>
            </li>
            <?php }?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      

        <div class="content-wrapper">
        <section class="content-header">
    
         <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="clear"></div>
        </section>

        <!-- Main content -->
        <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
        </section>
        </div>
    </div>

    
        <div id="overlay">
            <div class="overlay-body">
            <p class="overlay-msg"></p>
            <i class="icon-spinner icon-spin icon-2x"></i>
            </div>
            
    </div>
    
       <!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               提示
            </h4>
         </div>
         <div class="modal-body">
            	提示内容
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
	</div><!-- /.modal -->
    

     <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>随心赚</b>
        </div>
        <strong>Copyright &copy; <?= date('Y') ?> <a href="http://www.suoxinmr.com/">索信市场咨询（北京）有限公司</a></strong> 版权所有
      </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
