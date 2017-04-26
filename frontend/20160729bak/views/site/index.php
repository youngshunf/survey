<?php
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
$this->title = '首页';
$this->registerJsFile('@web/js/echarts/echarts.js', ['position'=> View::POS_HEAD]);
?>

<?php if(yii::$app->user->identity->role_id==89){?>
   <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?= $total_task?></h3>
                  <p>任务数量</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?= Url::to(['task/sp-task'])?>" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>￥<?= !$total_price?0:$total_price?><sup style="font-size: 20px"></sup></h3>
                  <p>任务总额</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?= Url::to(['finance/member'])?>" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?= $total_user?></h3>
                  <p>用户数量</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?= Url::to(['user/index'])?>" class="small-box-footer">更多<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?= !$total_view?0:$total_view?></h3>
                  <p>任务浏览量</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="<?= Url::to(['task/sp-task'])?>" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
<?php }?>



        <div class="row">
            <div class="col-lg-12 ">
            <div class="box box-info">
               <div class="box-header with-border">一周任务总览</div>
               <div class="box-body">
              <div id="week-task"  class="echarts-container"></div>
                </div>
            </div>
            </div>

      
       
        </div>
    <script type="text/javascript">
    // Step:3 conifg ECharts's path, link to echarts.js from current page.
    // Step:3 为模块加载器配置echarts的路径，从当前页面链接到echarts.js，定义所需图表路径
    require.config({
        paths: {
            echarts: '<?= yii::getAlias('@web')?>/js/echarts'
        }
    });
    
    // Step:4 require echarts and use it in the callback.
    // Step:4 动态加载echarts然后在回调函数中开始使用，注意保持按需加载结构定义图表路径
    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
          
        ],
        function (ec) {
            //--- 折柱 ---
            var myChart = ec.init(document.getElementById('week-task'));
            myChart.setOption({
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['待审核','审核通过','已结束','审核未通过']
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : ['周一','周二','周三','周四','周五','周六','周日']
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        splitArea : {show : true}
                    }
                ],
                series : [
                    {
                        name:'待审核',
                        type:'bar',
                        data:[Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20)]
                    },
                    {
                        name:'审核通过',
                        type:'bar',
                        data:[Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20)]
                    },
                    {
                        name:'已结束',
                        type:'bar',
                        data:[Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20)]
                    },
                    {
                        name:'审核未通过',
                        type:'bar',
                        data:[Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20), Math.ceil(Math.random()*20)]
                    },
                ]
            });
            
            // --- 地图 ---
        /*     var myChart2 = ec.init(document.getElementById('mainMap'));
            myChart2.setOption({
                tooltip : {
                    trigger: 'item',
                    formatter: '{b}'
                },
                series : [
                    {
                        name: '中国',
                        type: 'map',
                        mapType: 'china',
                        selectedMode : 'multiple',
                        itemStyle:{
                            normal:{label:{show:true}},
                            emphasis:{label:{show:true}}
                        },
                        data:[
                            {name:'广东',selected:true}
                        ]
                    }
                ]
            }); */
        }
    );
    </script>
