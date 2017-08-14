<?php

namespace common\models;

use Yii;

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
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'number', 'radius','do_radius', 'name','do_type',  'province', 'city', 'district', 'address','end_time','price','max_times','is_show_price'],'required','on'=>['create','update']],
            [[ 'number', 'radius', 'status', 'group_id','do_radius','do_type','answer_radius','answer_type','max_times','type','is_show_price'], 'integer'], 
            [['price', 'total_price','group_id'], 'number'],
            [['end_time'],'safe'],
            [['name','province', 'city', 'district', 'address'], 'string', 'max' => 255],
            
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
            'name' => '任务名称',
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
    
    public function getUser(){
        return $this->hasOne(AdminUser::className(),['user_guid'=>'user_guid']);
    }
    
    public function getGroup(){
        return $this->hasOne(Group::className(), ['group_id'=>'group_id']);
    }
}
