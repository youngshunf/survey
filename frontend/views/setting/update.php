<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '更新个人信息';
$this->params['breadcrumbs'][] = '更新个人信息';
?>
<div class="row">
	<div class="col-lg-3"></div>
	
	<div class="col-lg-6">
	<div class="panel-white">
	
    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

	</div>
	</div>
	<div class="col-lg-3"></div>
</div>

