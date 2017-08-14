<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => 20]) ?>
    <?php if($model->isNewRecord){?>
    <?= $form->field($model, 'role_id')->dropDownList(['98'=>'平台系统管理员','97'=>'平台质检员','96'=>'平台观察员']) ?>
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
