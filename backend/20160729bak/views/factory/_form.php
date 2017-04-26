<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AutoFactory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-factory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'province')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'postcode')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'telzone')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => 64]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
