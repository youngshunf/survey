<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">


    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <h3><?= Html::encode($this->title) ?></h3>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->label('用户名') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>
                <?= $form->field($model, 'rememberMe')->checkbox()->label('记住我') ?>
                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>
