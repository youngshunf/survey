<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Maintenance */

$this->title = '取消服务: ' . ' ' . $model->maintenance_num;
$this->params['breadcrumbs'][] = ['label' => '维修保养管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '取消服务';
?>

<div class="col-lg-1"></div>
	<div class="col-lg-10">
    <?= $this->render('_form-c', [
        'model' => $model,
    ]) ?>
	</div>
<div class="col-lg-1"></div>

