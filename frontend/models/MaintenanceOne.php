<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "maintenance".
 *
 * @property integer $id
 * @property string $maintenance_guid
 * @property string $user_guid
 * @property string $fours_guid
 * @property string $fours_id
 * @property string $book_time
 * @property string $book_m_date
 * @property integer $type
 * @property string $phone
 * @property integer $status
 * @property string $r_name
 * @property string $m_name
 * @property string $r_phone
 * @property string $m_time
 * @property string $cancel_book
 * @property string $cancel_book_time
 * @property string $cancel_m
 * @property string $cancel_m_time
 * @property string $next_m_time
 * @property string $created_at
 * @property string $updated_at
 */
class MaintenanceOne extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maintenance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['status'],'required'],
//         	['r_phone','match','pattern'=>'^[1][3-8]+\\d{9}$^','message'=>'请输入正确的手机号码'],
//         	[['r_phone'], 'string','max'=>11, 'min'=>11, 'tooLong'=>'手机号不能大于11位', 'tooShort'=>'手机号不能小于11位'],
        	
//             [['book_time', 'book_m_date', 'type', 'status', 'm_time', 'cancel_book_time', 'cancel_m_time', 'next_m_time', 'created_at', 'updated_at'], 'integer'],
            [['m_time','next_m_time'],'safe'],
            [['maintenance_guid', 'user_guid', 'fours_guid', 'fours_id'], 'string', 'max' => 48],
            [['phone', 'r_name', 'm_name', 'r_phone'], 'string', 'max' => 20],
            [['cancel_book', 'cancel_m'], 'string', 'max' => 125]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'maintenance_guid' => '维修保养订单guid',
            'user_guid' => '用户',
            'fours_guid' => '4S店',
            'fours_id' => '4S店编号',
            'book_time' => '预约时间',
            'book_m_date' => '预约保养时间',
            'type' => '类型',
            'phone' => '联系电话',
            'status' => '状态',
            'r_name' => '接待人',
            'm_name' => '维修保养人',
            'r_phone' => '接待人电话',
            'm_time' => '具体保养时间',
            'cancel_book' => '预约取消原因',
            'cancel_book_time' => '预约取消时间',
            'cancel_m' => '保养取消原因',
            'cancel_m_time' => '保养取消时间',
            'next_m_time' => '下次保养时间',
            'created_at' => '工单创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
