<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if($model->isNewRecord){?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'role_id')->dropDownList(['88'=>'系统管理员','87'=>'质检员','86'=>'观察员']) ?>
    <?php }?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>
   <?= $form->field($model, 'password')->passwordInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'nick')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'sex')->dropDownList(['1'=>'男','2'=>'女']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
