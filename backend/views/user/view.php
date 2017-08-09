<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">基本信息</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <div class="row">
                <div class=" col-md-3 col-sm-3">
                <?php if(empty($model->photo)){?>
                <img alt="" src="<?= yii::getAlias('@avatar')?>/unknown.jpg" class="img-responsive">
                <?php }else{?>
                <img alt="" src="<?= yii::getAlias('@avatar').'/'.$model->path.'thumb/'.$model->photo?>" class="img-responsive">
                <?php }?>
                </div>
                <div class=" col-md-9 col-sm-9">
                        <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            'mobile',
                            'alipay',
                			['attribute'=>'created_at','value'=>empty($model->created_at)?"":CommonUtil::fomatHours($model->created_at)],
                    		['attribute'=>'updated_at','value'=>empty($model->updated_at)?"":CommonUtil::fomatHours($model->updated_at)],
                        ],
                        'options'=>['class'=>'table table-striped  table-responsive'],
                    ]) ?>
                </div>
                </div>
                
        </div>
        </div>

<div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">个人资料</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
       <p>   
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除该项?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
    <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'age',
            'identityno',
            'mobile',
            'address',
            'email:email',
           'bank_name',
       
			['attribute'=>'created_at','value'=>empty($model->created_at)?"":CommonUtil::fomatHours($model->created_at)],
    	//	['attribute'=>'updated_at','value'=>empty($model->updated_at)?"":CommonUtil::fomatHours($model->updated_at)],
        ],
    ]) ?>
    </div>
        <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sex',
            'marital',
            'interest',
            'second_mobile',
            'homeland',
            'weixin',
           'bank_account',
       
		//	['attribute'=>'created_at','value'=>empty($model->created_at)?"":CommonUtil::fomatHours($model->created_at)],
    		['attribute'=>'updated_at','value'=>empty($model->updated_at)?"":CommonUtil::fomatHours($model->updated_at)],
        ],
    ]) ?>
    </div>
    </div>
</div>
</div>

<div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">个人学历与职业</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
    <div class="row">
    <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'top_edu',
            'graduate_school',
            'english_level',
            'post',
            'income_level',
 
       
        ],
    ]) ?>
    </div>
        <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'graduate_time',
            'major',
            'computer_level',
            'work_experience',
    
       
        ],
    ]) ?>
    </div>
    </div>
</div>
</div>

<div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">家庭信息</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
    <div class="row">
    <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'children_age',
            'estate',
    
 
       
        ],
    ]) ?>
    </div>
        <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'home_income',
            'car_num',

    
       
        ],
    ]) ?>
    </div>
    </div>
</div>
</div>
