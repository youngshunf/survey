<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Wallet */

$this->title = $model->user->name;
$this->params['breadcrumbs'][] = ['label' => 'Wallets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'non_payment',
            'paid',
            'total_income',

            'withdrawing',
        ],
    ]) ?>

</div>
    </div>

<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
           收入详情
        </div>
    </div>
    <div class="box-body">

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
                'amount',
                'remark',

                ['attribute'=>'created_at',
                    'label'=>'时间',
                    'format'=>['date','php: Y-m-d H:i:s'],
                ],

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>
