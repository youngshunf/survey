<?php 
use yii\bootstrap\Nav;
use common\models\Category;
use common\models\CommonUtil;
use common\models\GoodsCate;
?>
<!-- 先引用main.php布局文件， -->
<?php $this->beginContent('@app/views/layouts/main.php');?>
    <div class="row">
			<div class="col-lg-2  col-md-2">
			<div class="leftmenu">
        <?php  
            $id=@$_GET['id'];
            $menuItems[] = ['label' => '商品分类', 'url' => ['/goods/index'] ];
            $cates=GoodsCate::find()->all();
            foreach ($cates as $cate){
                $menuItems[] = ['label' =>$cate->name, 'url' => ['/goods/goods','id'=>$cate->id],'active'=>yii::$app->controller->action->id=='goods'&&$id==$cate->id  ];
            }
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
