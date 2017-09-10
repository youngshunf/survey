<?php

use common\models\CommonUtil;

?>	
<style>
.mui-ios .action-container{
		position: relative;
		}
.barcode-img{
		margin:10px;	
		}
.barcode-img,.barcode-img img{
/* 	display:inline-block; */
	width:70px;
	height:70px;
	border-radius:5px;
}
.img-upload{
/* 	display:inline-block; */
	width:70px;
	height:70px;
	border:1px solid #f0f0f0;
	border-radius:5px;
	text-align: center;
   line-height: 70px;
	margin:10px;
}
.img-upload .mui-icon{
	font-size:30px;
	color:#f0f0f0;
}
.input-group-addon{
	border: none;
background: none;
}
</style>
    <div class="hide question_name" name="<?= $task->name?>" task_guid="<?= $task->task_guid?>" answer_guid="<?= $answer->answer_guid ?>" offline_save="<?=$answer->offline_save?>"></div>
    <?php if(empty($question)){?>
        <ul class="mui-table-view" >
				<li class="mui-table-view-cell task-list"  >
				<p>请联络督导、客服获取更多信息！</p>
				</li>
			</ul>
    <?php }else{?>
    <div class="task-container">
        <div class="task-wrapper" id="slider">
            <?php foreach ($question as $k =>$v){?>
                <?php if($v->type==0){?>
                <div class="task-slide  <?php if($v->required==1) echo 'required'?>  <?= $k==0?'':'hide'?>"    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
              <ul class="mui-table-view " >
				<li class="mui-table-view-cell"> 
				<div>
					<p class="bold"><?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
					<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
					</p>
					<form class="mui-input-group"   type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
					   <?php $options=json_decode($v->options,true);
					       $i=0;
					       foreach ($options as $option){
					   ?>
					   <div type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
						<div class="mui-input-row mui-radio mui-left"   opened="<?= @$option['open']?>"  refered="<?= @$option['refer']?>">
						<label><?= ++$i?> 、<?= $option['opt']?></label>
						<input name="optArr<?= $k?>" value="<?= ($i-1).':'.$option['opt']?>" type="radio"  link="<?= $option['link']?>"  code="<?= $v->code?>"  opened="<?= @$option['open']?>"  refered="<?= @$option['refer']?>">
					  </div>
					  <?php if(!empty($option['open'])&&$option['open']==1){?>	
					  <input type="text" class="form-control  open-answer" placeholder="请输入" />
					  <?php }?>
					  </div>			  
					  <?php }?>
					 </form>
					
					</div>
				</li>
				</ul> 
				<div class="action-container">
				 <?php if($k==($count-1)){?>
				   <?php if($answer->offline_save==0){?>
				     <p class="mui-content-padded ">
				      <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
				     </p>
				     <p class="clear"></p>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }else{?>
					<p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }?>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <?php if($k!=0){?>
					 <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
					<?php }?>
					 <button class="mui-btn mui-btn-primary pull-right next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一页 </button>
					</p>
					<?php }?>
				</div>
                </div>	
                <?php }elseif ($v->type==1){?>
                  <div class="task-slide  <?php if($v->required==1) echo 'required'?> <?= $k==0?'':'hide'?>"    id="q<?= $v->code?>"  type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
                    <ul class="mui-table-view " >
        				<li class="mui-table-view-cell">
        				<div>
        					<p class="bold"><?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
        					<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
        					</p>
        					<form class="mui-input-group"  type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
        					   <?php $options=json_decode($v->options,true);
        					       $i=0;
        					       foreach ($options as $option){
        					   ?>
        						<div class="mui-input-row mui-checkbox mui-left">
        						<label><?= ++$i?> 、<?= $option?></label>
        						<input name="optArr<?= $k?>" value="<?= ($i-1).':'.$option?>" type="checkbox"  >
        					  </div>				  
        					  <?php }?>
        					 </form>
        					
        					</div>
        				</li>
				</ul>
				<div class="action-container">
				 <?php if($k==($count-1)){?>
				 	<?php if($answer->offline_save==0){?>
				     <p class="mui-content-padded ">
				      <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
				     </p>
				     <p class="clear"></p>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }else{?>
					<p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }?>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					  <?php if($k!=0){?>
					 <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
					<?php }?>
					 <button class="mui-btn mui-btn-primary pull-right next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一页 </button>
					</p>
					<?php }?>
				</div>
				</div>
                <?php }elseif ($v->type==2){?>
                  <div class="task-slide  <?php if($v->required==1) echo 'required'?> <?= $k==0?'':'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
                    <ul class="mui-table-view  ">
        				<li class="mui-table-view-cell">
        				<p class="bold"><?= $k+1?>: <?= $v->name?> (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
        				<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
        				</p>
        				</li>
        				<li class="mui-table-view-cell">
        				<div  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
        					   <textarea  rows="5" name="text<?= $k?>" ></textarea>
        					
        					</div>
        				</li>
        				</ul>
                    			<div class="action-container">
            				 <?php if($k==($count-1)){?>
            				 <?php if($answer->offline_save==0){?>
				     <p class="mui-content-padded ">
				      <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
				     </p>
				     <p class="clear"></p>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }else{?>
					<p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }?>
            					 <?php }else{?>
            					 <p class="mui-content-padded center" >
            					  <?php if($k!=0){?>
                					 <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
                					<?php }?>
            					 <button class="mui-btn mui-btn-primary pull-right next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一页 </button>
            					</p>
            					<?php }?>
            				</div>
        				</div>
                <?php }elseif ($v->type==3){?>
                <div class="task-slide  <?php if($v->required==1) echo 'required'?> <?= $k==0?'':'hide'?>"    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
                          <ul class="mui-table-view  ">
        				<li class="mui-table-view-cell">
        					<p class="bold"><?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
        					<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
        					</p>
        				</li>
        				<li  >
        				<input type="hidden" name="imgLen"  id="imgLen">
        				<div class="feedback">
        				<ul class="mui-table-view mui-grid-view mui-grid-9">
        				    <?php for($i=0;$i<$v->max_photo;$i++){?>		
        				    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-4 image-list-container">
											
        					<div class="row image-list" onclick="takePic(this)"   type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" imgIndex="<?= $i?>" >
        					<div class="image-item space">
        					<div class="image-close" >X</div>
        					</div>
        				     </div>
        				     </li>
        				     <?php }?>
        				     </ul>
        					
        					</div>
        				</li>
        				</ul>
        				<div class="action-container">
				 <?php if($k==($count-1)){?>
				     <?php if($answer->offline_save==0){?>
				     <p class="mui-content-padded ">
				      <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
				     </p>
				     <p class="clear"></p>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }else{?>
					<p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }?>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					  <?php if($k!=0){?>
					 <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
					<?php }?>
					 <button class="mui-btn mui-btn-primary pull-right next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一页 </button>
					</p>
					<?php }?>
				</div>
                </div>
                <?php }elseif ($v->type==4){?>
                 <div class="task-slide  <?php if($v->required==1) echo 'required'?> <?= $k==0?'':'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
                           <ul class="mui-table-view ">
        				<li class="mui-table-view-cell">
        				<div>
        					<p class="bold"><?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
        					<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
        					</p>
        					  <div id="record<?= $v->code?>">
        					   <button class="mui-btn mui-btn-warning mui-btn-block start"  onclick="startRecord('<?= $v->question_guid?>','<?= $v->code?>')">开始录音</button>
        					   <div class="stop-record hide">
        					   <p id="rec-text" class='red' >正在录音</p>
        					   <button class="mui-btn mui-btn-warning mui-btn-block stop"  onclick="stopRecord()">停止录音</button>
        					   </div>
        					   </div>
            					<ul id="audio-history-<?= $v->code?>" class="dlist" style="text-align:left;">
            						<li id="empty" class="ditem-empty"></li>
            					</ul>
        					</div>
        				</li>
        				</ul>
        				<div class="action-container">
            				 <?php if($k==($count-1)){?>
                				<?php if($answer->offline_save==0){?>
				     <p class="mui-content-padded ">
				      <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
				     </p>
				     <p class="clear"></p>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }else{?>
					<p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }?>
            					 <?php }else{?>
            					 <p class="mui-content-padded center" >
            					  <?php if($k!=0){?>
            					 <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
            					<?php }?>
            					 <button class="mui-btn mui-btn-primary pull-right next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一页 </button>
            					</p>
            					<?php }?>
            				</div>
                </div>
                <?php }elseif($v->type==5 || $v->type==8){?>
                 <div class="task-slide  <?php if($v->required==1) echo 'required'?> <?= $k==0?'':'hide'?>"    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
                          <ul class="mui-table-view ">
        				<li class="mui-table-view-cell">
        				<p class="bold"><?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
        				<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
        				</p>
        				</li>
        					<li class="mui-table-view-cell">
        				<div>
        					
        				<div id="dcontent" class="dcontent mui-center">
						<div class="mui-btn mui-btn-warning mui-btn-block" onclick="startScan(<?= $v->code?>)">扫一扫</div>
						<?php if($v->type==8){?>
						 <input class="mui-input form-control inputcode" readonly="readonly" type="text" id="inputcode<?= $v->code?>" class="请扫描二维码" >
						<?php }else{?>
						<div class="input-group">
						  <input class="mui-input form-control inputcode" type="text" id="inputcode<?= $v->code?>" class="请扫描或输入编码" >
						   <span class="input-group-addon" ><button class="btn btn-warning search-code" code="<?= $v->code?>">查询</button></span>
						 </div>
						 
						<br/>
						<ul id="barcode-history<?= $v->code?>" class="dlist mui-table-view codehistory" style="text-align:left;" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
							<li id="nohistory" class="ditem" onclick="onempty();">	</li>
						</ul>
						<ul id="barcodeQuestion<?= $v->code?>" class="dlist mui-table-view " style="text-align:left;" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
							<li class="mui-table-view-cell">
							<p>a、请输入店名和地址<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>: </p>	
							<input class="mui-input form-control baraddr" type="text" >
							</li>
							<li class="mui-table-view-cell">
							<p>b、请上传门店照片和查询结果截图 <?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>:</p>	
							<div class="barcode-img-container row" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" >
							
							<div class="col-xs-3 img-upload"  type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" >
							<span class="mui-icon mui-icon-plusempty" > </span>
							</div>
							</div>
							</li>
						</ul>
						<br/>
						<?php }?>
						
					</div>
        					</div>
        				</li>
        				</ul>
        				<div class="action-container">
				 <?php if($k==($count-1)){?>
				    <?php if($answer->offline_save==0){?>
				     <p class="mui-content-padded ">
				      <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
				     </p>
				     <p class="clear"></p>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }else{?>
					<p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }?>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					  <?php if($k!=0){?>
					 <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
					<?php }?>
					 <button class="mui-btn mui-btn-primary pull-right next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一页 </button>
					</p>
					<?php }?>
				</div>
        			</div>
                <?php }elseif ($v->type==6){?>
                <div class="task-slide  <?php if($v->required==1) echo 'required'?> <?= $k==0?'':'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" >
                           <ul class="mui-table-view ">
        				<li class="mui-table-view-cell">
        				<div>
        					<p class="bold"><?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
        					<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
        					</p>
            					<ul  class=" location "  >
            						
            					</ul>
            				
            					 <button class="mui-btn mui-btn-warning mui-btn-block  location-btn"   id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" >立即定位</button>
        					
        					
        				</div>
        				</li>
        				</ul>
        				<div class="action-container">
        				 <?php if($k==($count-1)){?>
        				 <?php if($answer->offline_save==0){?>
				     <p class="mui-content-padded ">
				      <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
				     </p>
				     <p class="clear"></p>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }else{?>
					<p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }?>
        					 <?php }else{?>
        					 <p class="mui-content-padded center" >
                					  <?php if($k!=0){?>
        					 <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
        					<?php }?>
        					 <button class="mui-btn mui-btn-primary pull-right next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一页 </button>
        					</p>
        					<?php }?>
        				</div>
                </div>
                
                <?php }elseif ($v->type==7){
                $options=json_decode($v->options,true);
                    ?>
                 <div class="task-slide  <?php if($v->required==1) echo 'required'?> <?= $k==0?'':'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" >
                    <ul class="mui-table-view  ">
        				<li class="mui-table-view-cell">
        				<p class="bold"><?= $k+1?>: <?= $v->name?> (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
        				<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
        				</p>
        				</li>
        				<li class="mui-table-view-cell">
        				<div  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
        					   <input type="number"  name="number<?= $k?>"  min="<?= $options['min']?>" max="<?= $options['max']?>" class="form-control number">
        					</div>
        				</li>
        				</ul>
        				<div class="action-container">
				 <?php if($k==($count-1)){?>
				 <?php if($answer->offline_save==0){?>
				     <p class="mui-content-padded ">
				      <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
				     </p>
				     <p class="clear"></p>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save"  >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }else{?>
					<p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					<?php }?>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					  <?php if($k!=0){?>
					 <button class="mui-btn mui-btn-primary pull-left preview"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 上一页 </button>
					<?php }?>
					 <button class="mui-btn mui-btn-primary pull-right next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一页 </button>
					</p>
					<?php }?>
				</div>
        			</div>
                
                <?php }?>
           <?php }?>
           
          </div>
          </div>
     <?php }?>
				
			
