<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Maintenance */

$this->title = '取消工单: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '维修保养管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '取消工单';
?>
<div class="maintenance-update">
<div class="col-lg-1"></div>
	<div class="col-lg-10">
    <?= $this->render('_form-delete', [
        'model' => $model,
    ]) ?>
	</div>
<div class="col-lg-1"></div>
</div>
