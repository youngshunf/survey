<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '更新用户信息: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新用户信息';
?>

<div class="col-lg-1"></div>
	<div class="col-lg-10">
	<div class="panel-white">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
	</div>
	<div class="col-lg-1"></div>

