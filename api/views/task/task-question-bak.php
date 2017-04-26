<?php

use common\models\CommonUtil;

?>	
    <div class="hide question_name" name="<?= $task->name?>" task_guid="<?= $task->task_guid?>" ></div>
    <?php if(empty($question)){?>
        <ul class="mui-table-view" >
				<li class="mui-table-view-cell task-list"  >
				<p>暂时没有问卷。</p>
				</li>
			</ul>
    <?php }else{?>
            <?php foreach ($question as $k =>$v){?>
                <?php if($v->type==0){?>
                <ul class="mui-table-view  <?= $k==0?'':'hide'?>"  id="q<?= $v->code?>">
				<li class="mui-table-view-cell">
				<div>
					<p class="bold">问题<?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)</p>
					<form class="mui-input-group">
					   <?php $options=json_decode($v->options,true);
					       $i=0;
					       foreach ($options as $option){
					   ?>
						<div class="mui-input-row mui-radio mui-left">
						<label><?= ++$i?> 、<?= $option['opt']?></label>
						<input name="optArr<?= $k?>" value="<?= ($i-1).':'.$option['opt']?>" type="radio"  link=<?= $option['link']?> >
					  </div>				  
					  <?php }?>
					 </form>
					 <p class="mui-content-padded center" >
					 <button class="mui-btn mui-btn-primary <?= $k==($count-1)?'submit':'next'?>"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>" code="<?= $v->code?>"> <?= $k==($count-1)?'提交':'下一题'?></button>
					</p>
					</div>
				</li>
				</ul>
                
                <?php }elseif ($v->type==1){?>
                    <ul class="mui-table-view  <?= $k==0?'':'hide'?>"  id="q<?= $v->code?>">
        				<li class="mui-table-view-cell">
        				<div>
        					<p class="bold">问题<?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)</p>
        					<form class="mui-input-group">
        					   <?php $options=json_decode($v->options,true);
        					       $i=0;
        					       foreach ($options as $option){
        					   ?>
        						<div class="mui-input-row mui-checkbox mui-left">
        						<label><?= $i++?> 、<?= $option?></label>
        						<input name="optArr<?= $k?>" value="<?= ($i-1).':'.$option?>" type="checkbox"  >
        					  </div>				  
        					  <?php }?>
        					 </form>
        					 <p class="mui-content-padded center" >
        					 <button class="mui-btn mui-btn-primary <?= $k==($count-1)?'submit':'next'?>"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" > <?= $k==($count-1)?'提交':'下一题'?></button>
        					</p>
        					</div>
        				</li>
				</ul>
                <?php }elseif ($v->type==2){?>
                    <ul class="mui-table-view  <?= $k==0?'':'hide'?>"  id="q<?= $v->code?>">
        				<li class="mui-table-view-cell">
        				<div>
        					<p class="bold">问题<?= $k+1?>: <?= $v->name?> (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)</p>
        					   <textarea  rows="5" name="text<?= $k?>" ></textarea>
        					 <p class="mui-content-padded center" >
        					 <button class="mui-btn mui-btn-primary <?= $k==($count-1)?'submit':'next'?>"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>"> <?= $k==($count-1)?'提交':'下一题'?></button>
        					</p>
        					</div>
        				</li>
        				</ul>
                <?php }elseif ($v->type==3){?>
                          <ul class="mui-table-view  <?= $k==0?'':'hide'?>"  id="q<?= $v->code?>">
        				<li class="mui-table-view-cell">
        				<div>
        					<p class="bold">问题<?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)</p>
        					   <div class="img-container center">
            						<div class="uploadify-button"></div>
            					</div>
            					<input type="hidden" name="imgLen" id="imgLen">
        					 <p class="mui-content-padded center" >
        					 <button class="mui-btn mui-btn-primary <?= $k==($count-1)?'submit':'next'?>"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>"> <?= $k==($count-1)?'提交':'下一题'?></button>
        					</p>
        					</div>
        				</li>
        				</ul>
                
                <?php }elseif ($v->type==4){?>
                           <ul class="mui-table-view  <?= $k==0?'':'hide'?>"  id="q<?= $v->code?>">
        				<li class="mui-table-view-cell">
        				<div>
        					<p class="bold">问题<?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)</p>
        					   <button class="mui-btn mui-btn-warning mui-btn-block" onclick="startRecord()">开始录音</button>
            					<ul id="history" class="dlist" style="text-align:left;">
            						<li id="empty" class="ditem-empty"></li>
            					</ul>
        					 <p class="mui-content-padded center" >
        					 <button class="mui-btn mui-btn-primary <?= $k==($count-1)?'submit':'next'?>"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>"> <?= $k==($count-1)?'提交':'下一题'?></button>
        					</p>
        					</div>
        				</li>
        				</ul>
                
                <?php }elseif($v->type==5){?>
                                  <ul class="mui-table-view  <?= $k==0?'':'hide'?>"  id="q<?= $v->code?>">
        				<li class="mui-table-view-cell">
        				<div>
        					<p class="bold">问题<?= $k+1?>: <?= $v->name?>  (<?= CommonUtil::getDescByValue('question', 'type', $v->type)?>)</p>
        					   <div class="qrcode-container center">
            						<div class="uploadify-button"></div>
            					</div>
            					<input type="hidden" name="qrLen" id="qrLen">
            					<input type="hidden" name="qrvalue" id="qrvalue">
        					 <p class="mui-content-padded center" >
        					 <button class="mui-btn mui-btn-primary <?= $k==($count-1)?'submit':'next'?>"  type="<?= $v->type?>"  task_guid="<?= $v->task_guid?>" question_guid="<?= $v->question_guid?>"  code="<?= $v->code?>" > <?= $k==($count-1)?'提交':'下一题'?></button>
        					</p>
        					</div>
        				</li>
        				</ul>
                <?php }?>
           <?php }?>
     <?php }?>
				
			
