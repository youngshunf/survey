<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Roadside */

$this->title = '确认救援: ' . ' ' . $model->roadside_num;
$this->params['breadcrumbs'][] = ['label' => '道路救援', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->roadside_num, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
    <div class="col-md-2"></div>
</div>