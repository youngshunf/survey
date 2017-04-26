<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/mui.min.css');
?>
<style type="text/css">
#l-map{
	width:100%;
	height:800px;
}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=SVLNGzI1VsyomtoL7mB342Ok"></script>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
      <?= $this->title ?>
    </div>
</div>

   <div class="box-body">
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => '您确定要删除此项目吗?',
                'method' => 'post',
            ],
        ]) ?>
         <?= Html::a('修改整体属性', ['update-task', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('复制项目', ['copy-project', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <button class="btn btn-primary importTask">问卷模板批量导入</button>
        <button class="btn btn-primary importTaskTemplate">任务模板批量导入</button>
         <?= Html::a('列表模式', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'tasknum',
            ['attribute'=>'任务进度',
            'value'=>$doneRate.'%',
            ],
           ['attribute'=>'created_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
        ],
    ]) ?>

    
</div>
</div>

<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
     项目任务
    </div>
</div>
    <div class="box-body">
    
	<div id="l-map"></div>
 
    </div>
</div>

 
 <script type="text/javascript">
	var map = new BMap.Map("l-map");            // 创建Map实例
	map.centerAndZoom(new BMap.Point(<?= $taskList[0]->lng?>,<?= $taskList[0]->lat?>), 12);//设置当前位置为中心点
	var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});
	var top_left_navigation = new BMap.NavigationControl(); 
	map.addControl(top_left_control);
	map.addControl(top_left_navigation); 
	getMapTask();
	
	var opts = {
					width : 300,     // 信息窗口宽度
					height: 200,     // 信息窗口高度
//								title : "信息窗口" , // 信息窗口标题
					enableMessage:true//设置允许信息窗发送短息
			   };
  function getMapTask(){
		
		var data_info = <?= json_encode($data)?>;
        console.log(data_info);
		for(var i=0;i<data_info.length;i++){
			var marker = new BMap.Marker(new BMap.Point(data_info[i][0],data_info[i][1]));  // 创建标注
			var content = data_info[i][2];
			map.addOverlay(marker);               // 将标注添加到地图中
			addClickHandler(content,marker);
		}
	}

  function addClickHandler(content,marker){
		marker.addEventListener("click",function(e){
			openInfo(content,e)}
		);
	}
	function openInfo(content,e){
		var p = e.target;
		var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
		var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
		map.openInfoWindow(infoWindow,point); //开启信息窗口
		infoWindow.OnInfoWindowClickListener('click',function(){
			alert('click'+JSON.stringify(p));
		})
	}
		
</script>
 
