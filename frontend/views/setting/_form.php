<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'nick',['options'=>['class'=>'input-group ']])->textInput(['maxlength' => 32])->label('昵称',['class'=>'input-group-addon']) ?>
	</br>
    <?= $form->field($model, 'gender',['options'=>['class'=>'input-group ']])->dropDownList([ 'n/a' => '保密','m'=>'男','f'=>'女' ], ['prompt' => ''])->label('性别',['class'=>'input-group-addon']) ?>
	</br>
    <?= $form->field($model, 'mobile',['options'=>['class'=>'input-group ']])->textInput(['maxlength' => 11])->label('手机号',['class'=>'input-group-addon']) ?>
	</br>
    <?= $form->field($model, 'email',['options'=>['class'=>'input-group ']])->textInput(['maxlength' => 48])->label('邮箱',['class'=>'input-group-addon']) ?>
	</br>
    <?= $form->field($model, 'pw_question',['options'=>['class'=>'input-group ']])->textInput(['maxlength' => 48])->label('密保问题',['class'=>'input-group-addon']) ?>
	</br>
    <?= $form->field($model, 'pw_answer',['options'=>['class'=>'input-group ']])->textInput(['maxlength' => 48])->label('密保答案',['class'=>'input-group-addon']) ?>
	</br>
    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         <?= Html::a('返回', ['view'], ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
