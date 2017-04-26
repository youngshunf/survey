<?php

use common\models\CommonUtil;

?>	
    <div class="hide question_name" name="<?= $task->name?>" task_guid="<?= $task->task_guid?>" answer_guid="<?= $answer->answer_guid ?>"></div>
    <?php if(empty($question)){?>
        <ul class="mui-table-view" >
				<li class="mui-table-view-cell task-list"  >
				<p>请联络督导、客服获取更多信息！</p>
				</li>
			</ul>
    <?php }else{?>
    <div class="swiper-container">
        <div class="swiper-wrapper" id="slider">
            <?php foreach ($question as $k =>$v){?>
                <?php if($v->type==0){?>
                <div class="swiper-slide  <?php if($v->required==1) echo 'required'?>  <?php if($v->refered==1) echo 'hide'?>"    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
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
					 <?php if($k==($count-1)){?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一题 </button>
					</p>
					<?php }?>
					</div>
				</li>
				</ul> 
                </div>	
                <?php }elseif ($v->type==1){?>
                  <div class="swiper-slide  <?php if($v->required==1) echo 'required'?> <?php if($v->refered==1) echo 'hide'?>"    id="q<?= $v->code?>"  type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
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
        					 <?php if($k==($count-1)){?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一题 </button>
					</p>
					<?php }?>
        					</div>
        				</li>
				</ul>
				</div>
                <?php }elseif ($v->type==2){?>
                  <div class="swiper-slide  <?php if($v->required==1) echo 'required'?> <?php if($v->refered==1) echo 'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
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
        					 <?php if($k==($count-1)){?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一题 </button>
					</p>
					<?php }?>
        					</div>
        				</li>
        				</ul>
        				</div>
                <?php }elseif ($v->type==3){?>
                <div class="swiper-slide  <?php if($v->required==1) echo 'required'?> <?php if($v->refered==1) echo 'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
                          <ul class="mui-table-view  ">
        				<li class="mui-table-view-cell">
        					<p class="bold"><?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)
        					<?php if($v->required==1){?>
        				<span class="red">*</span>
        				<?php }?>
        					</p>
        				</li>
        				<input type="hidden" name="imgLen"  id="imgLen">
        				<div class="feedback">
        				<ul class="mui-table-view mui-grid-view mui-grid-9">
        				    <?php for($i=0;$i<$v->max_photo;$i++){?>		
        				    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-4">
											
        					<div class="row image-list"   type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" imgIndex="<?= $i?>" >
        					<div class="image-item space">
        					
        					</div>
        				     </div>
        				     </li>
        				     <?php }?>
        				     </ul>
        					 <?php if($k==($count-1)){?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一题 </button>
					</p>
					<?php }?>
        					</div>
        				
        				</ul>
                </div>
                <?php }elseif ($v->type==4){?>
                 <div class="swiper-slide  <?php if($v->required==1) echo 'required'?> <?php if($v->refered==1) echo 'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
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
        					 <?php if($k==($count-1)){?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一题 </button>
					</p>
					<?php }?>
        					</div>
        				</li>
        				</ul>
                </div>
                <?php }elseif($v->type==5){?>
                 <div class="swiper-slide  <?php if($v->required==1) echo 'required'?> <?php if($v->refered==1) echo 'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>">
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
						<br/>
						<img style="width:40%" class="center" id="bimg" src="../images/barcode.png"/>
						<br/>
						<br/>
						<div class="mui-btn mui-btn-danger mui-btn-block" onclick="startScan(<?= $v->code?>)">扫一扫</div>
						<br/>
						<ul id="barcode-history<?= $v->code?>" class="dlist" style="text-align:left;">
							<li id="nohistory" class="ditem" onclick="onempty();">	</li>
						</ul>
						<br/>
						
					</div>
        					 <?php if($k==($count-1)){?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一题 </button>
					</p>
					<?php }?>
        					</div>
        				</li>
        				</ul>
        			</div>
                <?php }elseif ($v->type==6){?>
                <div class="swiper-slide  <?php if($v->required==1) echo 'required'?> <?php if($v->refered==1) echo 'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" >
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
        					 <?php if($k==($count-1)){?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一题 </button>
					</p>
					<?php }?>
        					
        				</div>
        				</li>
        				</ul>
                </div>
                
                <?php }elseif ($v->type==7){
                $options=json_decode($v->options,true);
                    ?>
                 <div class="swiper-slide  <?php if($v->required==1) echo 'required'?> <?php if($v->refered==1) echo 'hide'?> "    id="q<?= $v->code?>" type="<?=$v->type?>" task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" >
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
        					 <?php if($k==($count-1)){?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-warning  save" >离线保存</button>
					 <button class="mui-btn mui-btn-primary submit"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 立即提交 </button>
					</p>
					 <?php }else{?>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary next"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> 下一题 </button>
					</p>
					<?php }?>
        					</div>
        				</li>
        				</ul>
        			</div>
                
                <?php }?>
           <?php }?>
           
          </div>
          </div>
     <?php }?>
				
			
