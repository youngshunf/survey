<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '新增app首页轮播图';
$this->params['breadcrumbs'][] = ['label' => '系统管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_photo_form', [
        'model' => $model,
    ]) ?>

</div>
