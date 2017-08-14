<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Circle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="circle-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'lng')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'lat')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'permissions')->textInput() ?>

    <?= $form->field($model, 'count_reply')->textInput() ?>

    <?= $form->field($model, 'count_love')->textInput() ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
