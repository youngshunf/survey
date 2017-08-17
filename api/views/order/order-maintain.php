<?php
use common\models\CommonUtil;

?>	
        <img src="<?=yii::getAlias('@photo').'/maintain.png'?>" class="img-responsive" />
		
		<ul class="mui-table-view" style="margin-top:0px" >
			<li class="mui-table-view-cell">																									
				<div class="mui-pull-left">
				<p> <a id="order-status">状态:<?= CommonUtil::getDescByValue('maintain', 'status', $orderInfo['status'])?></a></p>				
				</div>
				<div class="mui-pull-right" >
				<?php if($orderInfo['status']==0||$orderInfo['status']==1){?>
				<a class="mui-btn mui-btn-danger"  id="cancel" order_guid="<?=$order['order_guid']?>" >取消订单</a>
				<?php }elseif ($orderInfo['status']==2){?>				    
					<a class="mui-btn mui-btn-success" id="comment" order_guid="<?=$order['order_guid']?>" >进行评价</a>
					<a class="mui-btn mui-btn-success"  id="book-again">再次预约</a>
				<?php }else{ ?>
				<a class="mui-btn mui-btn-success" id="book-again">再次预约</a>
				<?php }?>
				</div>
			</li>
		<!--  	<li class="mui-table-view-cell">
				<div class="order-satus" >
			
				</div>
			</li>
			-->																					
		</ul>
			<ul class="mui-table-view">
			<li class="mui-table-view-cell">																													
			<p> 订单详情 <span class="mui-pull-right "><?=$orderInfo['order_no']?></span></p>									
			</li>
			<li class="mui-table-view-cell">
				<i class="icon-align-justify"></i> 订单类型:<?= $orderInfo['type']?>		
			</li>
			<li class="mui-table-view-cell">
				<i class="icon-time"></i> 下单时间:<?= $orderInfo['created_at']?>			
			</li>
		
			<li class="mui-table-view-cell mui-media">
				<i class="icon-calendar"></i> 预约日期:<?= $orderInfo['book_m_date']?>			
			</li>		
			
		</ul>
			<ul class="mui-table-view">
			<li class="mui-table-view-cell">
																									
				<div class="mui-pull-left">
				<p> 4S店详情</p>			
				</div>				
			</li>
			<li class="mui-table-view-cell">
				<span class="s-badge">4S</span>
				<span id="fours-name"><?= $orderInfo['fours_guid']['company']?></span>
			</li>
			<li class="mui-table-view-cell mui-media">
				<i class="icon-map-marker"></i>
				<span id="fours-address"><?= $orderInfo['fours_guid']['address']?></span> 			
			</li>		
			<li class="mui-table-view-cell mui-media">
				<i class="icon-phone"></i> 
				<span id="fours-mobile"><?= $orderInfo['fours_guid']['mobile']?></span>	
			</li>
	   </ul>

