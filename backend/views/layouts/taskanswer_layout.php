<?php 
use yii\bootstrap\Nav;
use common\models\NewsCate;
use yii\helpers\Url;
?>
<!-- 先引用main.php布局文件， -->
<?php $this->beginContent('@app/views/layouts/main.php');?>
    <div class="row">
			<div class="col-lg-12  col-md-12">
			<div class="leftmenu">
        <?php  
         $status=0;
         if(isset($_GET['status'])){
             $status=$_GET['status'];
         }
         $id=$_GET['id'];
          $menuItems[] = ['label' => '全部', 'url' => ['/task/view-answer','id'=>$id],'active'=>$status==0  ];    
          $menuItems[] = ['label' => '待提交', 'url' => ['/task/view-answer','id'=>$id, 'status'=>'1'], 'active'=>$status==1  ];
          if(yii::$app->user->identity->role_id==97){
              $menuItems[] = ['label' => '待审核', 'url' => ['/task/view-answer','id'=>$id,'status'=>'2'], 'active'=>$status==2  ];
          }
          
          $menuItems[] = ['label' => '合格', 'url' => ['/task/view-answer','id'=>$id,'status'=>'3'], 'active'=>$status==3  ];
          $menuItems[] = ['label' => '不合格', 'url' => ['/task/view-answer','id'=>$id,'status'=>'99'], 'active'=>$status==99  ];
            echo Nav::widget([
                'options' => ['class' => 'nav nav-pills '],
                'items' => $menuItems,
            ]);      
		?>
		 <div class="top-right">
		 <a class="btn btn-success " href="<?= Url::to(['export-answer','id'=>$id,'status'=>$status])?>">结果导出</a>
		
		 </div>
		</div>
		
        </div>
        <div class="col-lg-12 col-md-12"> 
        <?= $content ?>
        </div>
         </div>
<?php $this->endContent();?>
