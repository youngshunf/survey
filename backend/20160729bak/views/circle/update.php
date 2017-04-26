<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Circle */

$this->title = '修改车友圈 ' ;
$this->params['breadcrumbs'][] = ['label' => '车友圈管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
