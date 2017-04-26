<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title='车厂设置 ';
$this->params['breadcrumbs'][] = ['label' => '设置', 'url' => ['/setting/index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
 <div class="col-md-2"></div>
 <div class="col-md-8">
    <div class="panel-white">
    <h3>车厂信息</h3>
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
	<?= $form->field($model, 'short_name')->textInput(['maxlength' => 32])?>
	<?= $form->field($model, 'mobile')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'province')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'city')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'postcode')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'telzone')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'telephone')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'fax')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'contact')->textInput(['maxlength' => 32]) ?>
    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         <?= Html::a('返回', ['index'], ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
 <div class="col-md-2"></div>
</div>
