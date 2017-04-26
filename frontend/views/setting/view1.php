<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
/* @var $this yii\web\View */
/* @var $model backend\models\Enterprise */

$this->title = '个人信息';
$this->params['breadcrumbs'][] = ['label' => '首页', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-6">
    <?php if(empty($model->img_path)){?>
    	<img class="img-circle img-responsive" src="../../../upload/avatar/unknown.jpg" style="width: 150px;height: 150px;" />
    <?php }else{?>
    	<img class="img-circle img-responsive" src="../../../upload/avatar/<?php echo $model->img_path;?>" style="width: 200px;height: 200px;" />
    <?php }?>   
    <br>
    <div style="margin-left: 35px;"><?= Html::a('修改头像', ['update_img', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></div>
   	 <br>
    </div>
    <div class="col-lg-6">
    	<h1><?php echo $model->username;?></h1>
    	<p><strong>真实姓名:</strong>	<?php echo $model->real_name;?><br></p>
    	<p><strong>昵称:</strong>	<?php echo $model->nick;?><br>	</p>
    	<p><strong>邀请码:</strong> <?php echo $model->invite_code;?><br></p>
    	<p><strong>性别:</strong>	<?php echo CommonUtil::getDescByValue('user','gender',$model->gender);?><br></p>
    	<p><strong>上级用户:</strong> <?php function getUserName($upUserModel){
    		
    		if(!empty($upUserModel->real_name))
    			return $upUserModel->real_name;
    		else if(!empty($upUserModel->username))
    			return $upUserModel->username;
    		else if(!empty($upUserModel->email))
    			return $upUserModel->email;
    		else if(!empty($upUserModel->mobile))
    			return $upUserModel->mobile;
    	}
    	echo getUserName($upUserModel);
    	?><br></p>
    </div>
</div>

<div class="row">
	<div class="col-lg-12">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          
    		['attribute'=>'手机','value'=>empty($model->mobile)?"":$model->mobile],
    		['attribute'=>'手机验证','value'=>CommonUtil::getDescByValue('user','mobile_verify',$model->mobile_verify)],
    		['attribute'=>'绑定手机','value'=>empty($model->mobile_bind)?"":$model->mobile_bind],
    		['attribute'=>'邮箱', 'format'=>'email', 'value'=>empty($model->email)?"":$model->email],
    		['attribute'=>'邮箱验证','value'=>CommonUtil::getDescByValue('user','email_verify',$model->email_verify)],
    		['attribute'=>'绑定邮箱', 'format'=>'email', 'value'=>empty($model->email_bind)?"":$model->email_bind],          
    		['attribute'=>'是否启用', 'value'=>CommonUtil::getDescByValue('user','enable',$model->enable)],         
    		['attribute'=>'创建时间','value'=>empty($model->insert_time)?"":$model->insert_time],
    		['attribute'=>'更新时间','value'=>empty($model->update_time)?"":$model->update_time],
    		['attribute'=>'最后访问IP','value'=>empty($model->last_ip)?"":$model->last_ip],
    		['attribute'=>'最后访问时间','value'=>empty($model->last_time)?"":$model->last_time],
    	],
    ]) ?>
 <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>
    </div>
</div>
