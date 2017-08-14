<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->name.'选择模板';
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= $this->title?> </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
       <h5><?= $model->name?>--选择模板</h5>
    <?php $form=ActiveForm::begin([
        'action'=>'choose-template-do',
       'options'=>['onsubmit'=>'return check()']
    ])?>
    <input type="hidden" name="task_id" value="<?= $model->id?>">
    <input type="hidden" name="project_id" value="<?= @$project_id?>">
        <?= ListView::widget([
        'dataProvider'=>$dataProvider,
        'itemView'=>'_template_item',            
           'layout'=>"{items}\n{pager}"
        ])?>
        <div class="center">
        <?= Html::submitButton('确认提交',['class'=>'btn btn-warning'])?>
        </div>
    <?php ActiveForm::end()?>
    </div>
    </div>
<script>
function check(){
	var templateid=0;
	$(':radio:checked').each(function(){
	
	    if($(this).val()){
	    	templateid=$(this).val();
	    }
	});
	if(templateid==0){
	    modalMsg('请选择模板');
	    return false;
	}

	showWaiting('正在提交,请稍候...');
	return true;
}

  </script>

