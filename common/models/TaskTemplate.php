<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_template".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property integer $type
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $price
 * @property integer $number
 * @property integer $end_time
 * @property string $address
 * @property string $lng
 * @property string $lat
 * @property integer $radius
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $total_price
 * @property integer $group_id
 * @property integer $post_type
 * @property string $user_guid
 * @property string $lnglat
 * @property integer $do_type
 * @property string $path
 * @property string $photo
 * @property integer $stage
 * @property integer $do_radius
 * @property integer $answer_type
 * @property integer $answer_radius
 * @property string $templateno
 * @property integer $max_times
 * @property string $task_templateno
 */
class TaskTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'desc', 'user_guid', 'lnglat'], 'string'],
            [['type', 'number', 'end_time', 'radius', 'created_at', 'updated_at', 'group_id', 'post_type', 'do_type', 'stage', 'do_radius', 'answer_type', 'answer_radius', 'max_times'], 'integer'],
            [['price', 'total_price'], 'number'],
            [['province', 'city', 'district', 'address', 'path', 'photo'], 'string', 'max' => 255],
            [['lng', 'lat'], 'string', 'max' => 20],
            [['templateno', 'task_templateno'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'desc' => '描述',
            'type' => '类型',
            'province' => '省份',
            'city' => '城市',
            'district' => '地区',
            'price' => '任务单价',
            'number' => '配额',
            'end_time' => '任务截止时间',
            'address' => '任务地址',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'radius' => '覆盖范围',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'total_price' => '任务总额',
            'group_id' => '发布范围',
            'post_type' => '发布类型',
            'user_guid' => '任务创建者',
            'lnglat' => 'Lnglat',
            'do_type' => '做任务类型',
            'path' => 'Path',
            'photo' => 'Photo',
            'stage' => '步骤',
            'do_radius' => '可执行范围',
            'answer_type' => '结果约束类型',
            'answer_radius' => '约束距离',
            'templateno' => '问卷模板编号',
            'max_times' => '每人最多最大执行次数',
            'task_templateno' => '任务模板编号',
        ];
    }
    
    public static function generateTaskTemplateNO() {
        return 'TQ'.date('Ymdhis').rand(1000, 9999);
    }
}
