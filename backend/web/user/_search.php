<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'access_token') ?>

    <?= $form->field($model, 'imei') ?>

    <?= $form->field($model, 'imsi') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'nick') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'head_img') ?>

    <?php // echo $form->field($model, 'score') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'path') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
