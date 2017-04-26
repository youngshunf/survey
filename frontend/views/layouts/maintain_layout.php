<?php 
use yii\bootstrap\Nav;
use common\models\Category;
use common\models\CommonUtil;
?>
<!-- 先引用main.php布局文件， -->
<?php $this->beginContent('@app/views/layouts/main.php');?>
    <div class="row">
			<div class="col-lg-2  col-md-2">
			<div class="leftmenu">
        <?php  
            $menuItems[] = ['label' => '正在进行', 'url' => ['/maintain/index'] ];
           $menuItems[] = ['label' => '已完成', 'url' => ['/maintain/complete']  ];
           $menuItems[] = ['label' => '已取消', 'url' => ['/maintain/cancel']  ];

            echo Nav::widget([
                'options' => ['class' => 'nav nav-pills nav-stacked'],
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
