<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AutoFactory */

$this->title = '新增车厂';
$this->params['breadcrumbs'][] = ['label' => '车厂管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>
