<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GroupUser;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户分组-'.$group->group_name;
$this->params['breadcrumbs'][] = ['label' => '用户分组', 'url' => ['group']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
        分组-<?= $group->group_name?>
    </div>
</div>
    <div class="box-body">
<a class="btn btn-warning" href="#add-user" >添加用户</a>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'user.mobile',          
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{delete-group-user}',
                'buttons'=>[
                    'delete-group-user'=>function ($url,$model,$key){
                    return Html::a('从当前移除  ',$url,['title'=>'删除分组','data-confirm'=>'您确定要移除此分组吗?','class'=>'btn btn-danger']);
                    } ,
                ],
            ],
        ],
    ]); ?>
    </div>
</div>

<div class="box box-success"  id="add-user">
            <div class="box-header with-border">
              <h3 class="box-title">添加分组用户</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="显示/隐藏"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="关闭"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
             <?php $form=ActiveForm::begin([
                    'action'=>'add-group-user',
                   'options'=>['onsubmit'=>'return check()']
                ])?>
                <input type="hidden" name="groupid" value="<?= $group->group_id?>">
                    <?= ListView::widget([
                    'dataProvider'=>$userData,
                    'itemView'=>'_user_item',            
                       'layout'=>"{items}\n{pager}"
                    ])?>
     
   
            </div><!-- /.box-body -->
            <div class="box-footer">
              <p class="text-center">
                  <?= Html::submitButton('确认提交',['class'=>'btn btn-warning'])?>
              </p>
            </div><!-- /.box-footer-->
             <?php ActiveForm::end()?>
          </div><!-- /.box -->
            
<script>
$('#create-group').click(function(){
    $('#addgroup').modal('show');
});
$('#import-btn').click(function(){
    $("#import-group").modal('show');    
});

function checkImport(){
	if(!$("#groupFile").val()){
	    modalMsg("请选择分组文件");
	    return false;
	}

	   showWaiting("正在提交,请稍后...");
	return true;
}

</script>
<script>
        
 function check(){
	   var users=0;
	   $("input[type=checkbox]:checked").each(function(){
		    users++;
	   });

	   if(users==0){
		    modalMsg("请选择用户再提交");
		    return false;
	   }

	   showWaiting("正在提交,请稍候...");
	   return true;
 }
</script>