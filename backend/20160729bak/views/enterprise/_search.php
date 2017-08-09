<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchEnterprise */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-enterprise-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'password_hash') ?>

    <?= $form->field($model, 'auth_key') ?>

    <?= $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'access_token') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'role_id') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'user_guid') ?>

    <?php // echo $form->field($model, 'factory_guid') ?>

    <?php // echo $form->field($model, 'brand_guid') ?>

    <?php // echo $form->field($model, 'fours_guid') ?>

    <?php // echo $form->field($model, 'sp_guid') ?>

    <?php // echo $form->field($model, 'head_img') ?>

    <?php // echo $form->field($model, 'last_ip') ?>

    <?php // echo $form->field($model, 'last_login_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
