<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title='品牌设置 ';
$this->params['breadcrumbs'][] = ['label' => '设置', 'url' => ['/setting/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
 <div class="col-md-2"></div>
 <div class="col-md-8">
    <div class="panel-white">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

      <?= $form->field($model, 'brand_name')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'brand_logo')->fileInput(['maxlength' => 128]) ?>

    <div class="form-group">
        <?= Html::submitButton( '提交', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
 <div class="col-md-2"></div>
</div>
