<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wenyuan\ueditor\Ueditor;
use kartik\widgets\DateTimePicker;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/lrz.bundle.js', ['position'=> View::POS_HEAD]);
?>

<div class="row">

    <?php $form = ActiveForm::begin(['id'=>'goods-form','options' => ['enctype' => 'multipart/form-data','onsubmit'=>'return check()']]); ?>
    <div class="col-md-12">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-md-6">
     <?= $form->field($model, 'cate_guid')->dropDownList(ArrayHelper::map($cates, 'cate_guid', 'name'))->label('分类') ?>
      <?= $form->field($model, 'number')->textInput() ?>
        <?= $form->field($model, 'is_sale')->dropDownList(['1'=>'是','0'=>'否'])?>
     </div>
     <div class="col-md-6">
         <?= $form->field($model, 'price')->textInput() ?>
             <?= $form->field($model, 'shop_guid')->dropDownList(ArrayHelper::map($shop, 'shop_guid', 'name'))->label('店铺') ?>
                   <?= $form->field($model, 'end_time')->widget(DateTimePicker::className(),[
        'options' => ['placeholder' => '请选择自动下架时间'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]); ?>
     </div>
     
   


     <div class="col-md-12">
      <?= Ueditor::widget([
        'id'=>'desc',
        'model'=>$model,
        'attribute'=>'desc',
        'ucontent'=>$model->desc,
        ]) ?>
     
         <div class="form-group">
        <label class="control-label"> 封面图片</label>
        <div class="img-container">
        <?php if($model->isNewRecord||empty($model->photo)){?>
                <div class="uploadify-button"> 
                </div>
        <?php }else{?>
            <img alt="封面图片" src="<?= yii::getAlias('@photo').'/'.$model->path.'thumb/'.$model->photo?>" class="img-responsive">
        <?php }?>
        </div>
       <input type="file" name="photo"  class="hide"  id="photo">
       </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

         </div>
    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">

$('.img-container').click(function(){
    $('#photo').click();
})

document.getElementById('photo').addEventListener('change', function () {
    var that = this;
    lrz(that.files[0], {
        width: 300
    })
        .then(function (rst) {
            var img        = new Image();            
            img.className='img-responsive';
            img.src = rst.base64;    
            img.onload = function () {
           	 $('.img-container').html(img);
            };                 
            return rst;
        });
});

function check(){
	<?php if($model->isNewRecord){?>
    if(!$('#photo').val()){
        modalMsg('请上传照片');
        return false;
    }
    <?php }?>
  
    showWaiting('正在提交,请稍候...');
    return true;
}

</script>