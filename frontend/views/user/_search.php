<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_guid') ?>

    <?= $form->field($model, 'token') ?>

    <?= $form->field($model, 'pad_id') ?>

    <?= $form->field($model, 'mac') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'nick') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'head_img') ?>

    <?php // echo $form->field($model, 'score') ?>

    <?php // echo $form->field($model, 'vin') ?>

    <?php // echo $form->field($model, 'car_license') ?>

    <?php // echo $form->field($model, 'car_model') ?>

    <?php // echo $form->field($model, 'car_color') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'birth_date') ?>

    <?php // echo $form->field($model, 'purchase_date') ?>

    <?php // echo $form->field($model, 'fours_id') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
