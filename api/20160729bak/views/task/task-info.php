<?php

use common\models\CommonUtil;

?>	
 
	
 	<ul class="mui-table-view" >
				<li class="mui-table-view-cell task-list"  task_guid=<?= $taskArr['task_guid']?>>
				
					<div class="row">
						<div class="col-xs-12">
						<p ><b><?= $taskArr['name']?></b></p>	
						</div>
				
						<div class="col-xs-8">
							
							<p class="sub">发布:<?= CommonUtil::fomatDate($taskArr['created_at'])?></p>
							<p class="sub">截止:<?= CommonUtil::fomatDate($taskArr['end_time'])?></p>
						</div>
						<div class="col-xs-4">
						 <?php if($taskArr['is_show_price']==1){?>
							<p ><span class="sub">奖励: </span><span class="orange">￥<?= $taskArr['price']?></span></p>
							<?php }?>
							<p><span class="sub">剩余: <?= $taskArr['number']-$taskArr['count_done']?></span></p>
			
						</div>
						<div class="col-xs-12">
						<!-- 	<div class="progress">
			               <div class="progress-bar progress-bar-danger" role="progressbar" 
			                  aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" 	
			                  style="width: <?= round($taskArr['count_done']/$taskArr['number']*100)?>%;">		            
			               </div>
			                </div>
			                 -->
			                <p>
			                <span class="location sub"  lng="<?= $taskArr['lng']?>" lat="<?= $taskArr['lat']?>">地址: <?= $taskArr['address']?> （<?= sprintf("%.2f",($taskArr['dist']*30)/1000).'km'?>） </span>
			             <!--  <span class="pull-right"><span class="red"><?= $taskArr['count_done']?></span> / <?= $taskArr['number']?></span> --></p>
						    
						</div>
					</div>
				</li>
				<?php if($taskArr['count_done']>=$taskArr['number']){?>
				<li class="mui-table-view-cell">
				 <span class="btn btn-default pull-right">任务已满额</span>
				 </li>
				<?php }else{?>
				
        				<?php if(!empty($answer)){?>
        				<?php if($taskArr['status']==2){  ?>
        				
        				<li class="mui-table-view-cell">
        				   <p style="margin-top: 8px;">
        						    	<a class="btn btn-warning get-task"  href="#"   task_guid=<?= $taskArr['task_guid']?>> 领任务</a>
        						    	<?php
                                        if($answerCount>1){?>
        						    	<a class="btn  btn-warning pull-right do-task"  task_guid="<?= $taskArr['task_guid']?>"> 做任务</a>
        					           <?php  }?>
        					 </p>
        				</li>
        				<?php }}else{?>
        				<li class="mui-table-view-cell">
        					 <p class="center"><a class="btn btn-warning get-task"  href="#"   task_guid=<?= $taskArr['task_guid']?>> 领任务</a>					 					 	
        					 </p>
        				</li>
        				<?php }?>
				
				<?php }?>
				</ul>
<ul class="mui-table-view" >
				<li class="mui-table-view-cell ">
				任务详情
				</li>
					<li class="mui-table-view-cell ">
			<div>
			<?= $taskArr['desc']?>
			</div>
				</li>
</ul>
