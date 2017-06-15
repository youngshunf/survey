<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\CommonUtil;
use common\models\Task;
use common\models\Project;
use common\models\GeoCoding;
use common\models\ImageUploader;

/**
 * This is the model class for table "task".
 *
 * @property string $id
 * @property string $task_guid
 * @property string $name
 * @property string $desc
 * @property integer $type
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $price
 * @property integer $number
 * @property string $end_time
 * @property string $address
 * @property string $lng
 * @property string $lat
 * @property integer $radius
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $total_price
 * @property string $group_id
 */
class ProjectForm extends Model
{
    public $type;
    public $name;
    public $shop;
    public $desc;
     public $province;
     public $city;
     public $district;
    public $price;
     public $number;
     public $end_time;
     public $address;
     public $lng;
     public $lat;
     public $radius;
    public $status;
     public $created_at;
     public $updated_at;
     public $total_price;
     public $group_id;
     public $do_radius;
     public $do_type;
     public $max_times;
     public $is_show_price;
     public $answer_radius;
     public $answer_type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'number', 'radius','do_radius', 'name','do_type', 'price','max_times','is_show_price'],'required','on'=>['create','update']],
            [[ 'number', 'radius', 'status', 'group_id','do_radius','do_type','answer_radius','answer_type','max_times','type','is_show_price'], 'integer'], 
            [['price', 'total_price','group_id'], 'number'],
            [['end_time'],'safe'],
            [['name','shop', 'province', 'city', 'district', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_guid' => 'Task Guid',
            'name' => '项目名称',
            'shop'=>'门店渠道',
            'desc' => '描述',
            'type' => '类型一',
            'do_type' => '类型二',
            'post_type'=>'发布类型',
            'province' => '省份',
            'city' => '城市',
            'district' => '地区',
            'price' => '奖励(元)',
            'number' => '限额',
            'end_time' => '任务截止时间',
            'address' => '详细地址',
            'lng' => '经度',
            'lat' => '纬度',
            'radius' => '可见范围(米)',
            'do_radius' => '可执行范围(米)',
            'status' => '状态',
            'answer_radius'=>'约束距离(米)',
            'answer_type'=>'约束类型',
            'created_at' => '发布时间',
            'updated_at' => '更新时间',
            'total_price' => '任务总额',
            'group_id' => '发布对象',
            'max_times'=>'每人最多执行次数',
            'is_show_price'=>'是否在APP显示价格'
        ];
    }
    
    public function createProject() {
       
        $user_guid=yii::$app->user->identity->user_guid;
        $project=new Project();
        $project->user_guid=$user_guid;
        $project->name=$this->name;
        $project->shop=$this->shop;
        $project->created_at=time();
        if($project->save()){
            $project_id=$project->id;
        }else{
            yii::$app->getSession()->setFlash('error','项目创建失败！');
            return false;
        }
        $file=UploadedFile::getInstanceByName('addressfile');
        if(!isset($file)){
            yii::$app->getSession()->setFlash('error','文件上传失败,请重试');
            return false;
        }
        if ($file->extension!='xls'&&$file->extension!='xlsx'){
            yii::$app->getSession()->setFlash('error','导入失败,请上传excel文件');
            return false;
        }
        $photo=ImageUploader::uploadByName('photo');
        
        $objPHPExcel = \PHPExcel_IOFactory::load($file->tempName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,false,true,true);
        $result = 0;
        $irecord = 0;
        foreach ($sheetData as $record)
        {
            $irecord++;
            if($irecord<2){
                continue;
            }
            
            $temp=trim($record['E']);
            if(empty($temp)){
                continue;
            }
             
            $task=new Task();
            $task->user_guid=$user_guid;
            $task->task_guid=CommonUtil::createUuid();
            $A=trim($record['A']);
            $task->name=empty($A)?($this->name.trim($record['B'])):trim($record['A']);
            $task->type=$this->type;
            $task->do_type=$this->do_type;
            $task->answer_type=$this->answer_type;
            $task->radius=$this->radius;
            $task->do_radius=$this->do_radius;
            $task->answer_radius=$this->answer_radius;
            $task->price=$this->price;
            $task->number=$this->number;
            $task->province=trim($record['B']);
            $task->city=trim($record['C']);
            $task->district=trim($record['D']);
            $task->address=trim($record['E']);
            $F=trim($record['F']);
            $task->end_time=empty($F)?strtotime($this->end_time):strtotime(trim($record['F']));
            $task->desc=@$_POST['desc'];
            $task->taskno=@trim($record['G']);
            $task->project_id=$project_id;
            $task->is_show_price=$this->is_show_price;
            $task->created_at=time();
            if($photo){
                $task->path=$photo['path'];
                $task->photo=$photo['photo'];
            }
            if(empty($this->group_id)){
                $task->group_id=0;
            }else{
                $task->group_id=$this->group_id;
            }
             
            //地址转经纬度
            $geoCoding=new GeoCoding(yii::$app->params['baiduMapAK']);
            $georesult=$geoCoding->getLngLatFromAddress(urldecode($task->address));
            if($georesult['status']==0){
                $task->lng=$georesult['result']['location']['lng'];
                $task->lat=$georesult['result']['location']['lat'];
                $task->lnglat=CommonUtil::getGeomLnglat($task->lng, $task->lat);
            }
             
            if(!$task->save()){
                yii::$app->getSession()->setFlash('success','导入地址失败,请检查导入模板是佛正确!');
               return false;
            }
             $result++;
        }
        
        $project=Project::findOne($project_id);
        $project->tasknum+=$result;
        $project->save();
        yii::$app->getSession()->setFlash('success','导入成功,本次导入'.$result.'条数据');
        return $project_id;
    }
    
}
