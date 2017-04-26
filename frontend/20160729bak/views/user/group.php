<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GroupUser;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户分组管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
        分组用户
    </div>
</div>
    <div class="box-body">
<a class="btn btn-success" href="javascript:;" id="create-group">新建分组</a>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'group_id',
            'group_name',
            ['attribute'=>'用户数','value'=>function ($model){
               return GroupUser::find()->andWhere(['group_id'=>$model->group_id])->count(); 
            }],
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{view-group}{edit-group}{delete-group}',
                'buttons'=>[
                  'view-group'=>function ($url,$model,$key){
                   return Html::a('查看 | ',$url,['title'=>'查看分组用户']);
                    }  ,
                    'edit-group'=>function ($url,$model,$key){
                    return Html::a('修改 | ',$url,['title'=>'修改分组信息']);
                    } ,
                    'delete-group'=>function ($url,$model,$key){
                    return Html::a('删除  ',$url,['title'=>'删除分组','data-confirm'=>'您确定要删除此分组吗?分组删除后不可恢复']);
                    } ,
                ],
            ],
        ],
    ]); ?>
    </div>
</div>

<div class="modal fade" id="addgroup" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               新建分组
            </h4>
         </div>
         <div class="modal-body">            	
             <?= $this->render('_group_form') ?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
</div><!-- /.modal -->
            
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