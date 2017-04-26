<?php 
use yii\bootstrap\Nav;
use common\models\NewsCate;
?>
<!-- 先引用main.php布局文件， -->
<?php $this->beginContent('@app/views/layouts/main.php');?>
    <div class="row">
			<div class="col-lg-2  col-md-2">
			<div class="leftmenu">
        <?php  
         
          $menuItems[] = ['label' => '会员管理', 'url' => ['/user/index']  ];    
          $menuItems[] = ['label' => '用户分组', 'url' => ['/user/group']  ];
          $menuItems[] = ['label' => '平台管理员', 'url' => ['/user/manager']  ];
          $menuItems[] = ['label' => '第三方管理员', 'url' => ['/user/sp-manager']  ];
            echo Nav::widget([
                'options' => ['class' => 'nav nav-pills nav-stacked '],
                'items' => $menuItems,
            ]);      
		?>
		</div>
        </div>
        <div class="col-lg-10 col-md-10"> 
         <div class="panel-white">     
        <?= $content ?>
        </div>
        </div>
         </div>
<?php $this->endContent();?>
