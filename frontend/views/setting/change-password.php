<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title='修改密码 ';
$this->params['breadcrumbs'][] = ['label' => '个人中心', 'url' => ['/profile/view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">
<div class="panel-white">
     <h3 >修改密码</h3>
	       <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>
			<?= $form->field($model, 'password')->passwordInput()->label('原始密码')  ?>
			    <?= $form->field($model, 'newPassword')->passwordInput()->label('新密码')  ?>
                <?= $form->field($model, 'newPassword2')->passwordInput()->label('确认新密码') ?>
                 <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'Submit-button']) ?>
        
			<?php ActiveForm::end(); ?>
	</div>		
	</div>
			<div class="col-md-2"></div>
</div>