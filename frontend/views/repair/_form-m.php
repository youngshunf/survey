<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use common\models\CommonUtil;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Maintenance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maintenance-form">

     <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'next_m_time')->widget(DatePicker::classname(), [
		    'options' => ['placeholder' => '请选择时间'],
		    'pluginOptions' => [
		        'autoclose'=>true,
				'format' => 'yyyy-mm-dd'
		    ]
	])?>
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新工单', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>