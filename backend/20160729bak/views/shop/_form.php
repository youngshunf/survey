<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use wenyuan\ueditor\Ueditor;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/lrz.bundle.js', ['position'=> View::POS_HEAD]);
?>

<div class="row">

    <?php $form = ActiveForm::begin(['id'=>'shop-form','options' => ['enctype' => 'multipart/form-data','onsubmit'=>'return check()']]); ?>
    <div class="col-md-12">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    </div>
    
    <div class="col-md-6">
        <?= $form->field($model, 'province')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 32]) ?>
    
    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'lng')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'lat')->textInput(['maxlength' => 32]) ?>
    </div>
      <div class="col-md-6">
       <?= $form->field($model, 'type')->dropDownList(['0'=>'4S店','1'=>'第三方服务商']) ?>
    <div id="factory">
        <?= $form->field($model, 'factory_guid')->dropDownList(ArrayHelper::map($factory, 'factory_guid', 'name'))?>
        <?= $form->field($model, 'brand_guid')->dropDownList(ArrayHelper::map($brand, 'brand_guid', 'brand_name')) ?>
      </div>
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => 32]) ?>

    </div>

    <div class="col-md-12">
    
    <div class="form-group">
         <label>店铺介绍</label>
          <?= Ueditor::widget(['id'=>'desc',
                'model'=>$model,
                'attribute'=>'desc',
                'ucontent'=>$model->desc,
                ]);  ?>
        </div>
    
      <div class="form-group">
        <label class="control-label"> 店铺封面图片</label>
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
$("#shop-type").change(function(){
    if($(this).val()==0){
        $("#factory").removeClass('hide');
    }else if($(this).val()==1){
        $("#factory").addClass('hide');
    }
});

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
	
 /*    if($("#news-form").hasClass('has-error')){
     	 modalMsg('请填写完再提交');
       return false;
      } */
	
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
