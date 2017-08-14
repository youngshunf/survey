<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $order_guid
 * @property string $orderno
 * @property string $user_guid
 * @property integer $type
 * @property double $amount
 * @property integer $is_pay
 * @property integer $pay_type
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $biz_guid
 * @property string $goods_name
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_guid'], 'required'],
            [['order_guid', 'user_guid', 'biz_guid'], 'string'],
            [['type', 'is_pay', 'pay_type', 'created_at', 'updated_at', 'status'], 'integer'],
            [['amount'], 'number'],
            [['orderno'], 'string', 'max' => 64],
            [['goods_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_guid' => 'Order Guid',
            'orderno' => '订单编号',
            'user_guid' => 'User Guid',
            'type' => '订单类型',
            'amount' => '订单金额',
            'is_pay' => '是否支付',
            'pay_type' => '支付方式',
            'created_at' => '充值时间',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'biz_guid' => 'Biz Guid',
            'goods_name' => '商品名称',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(AdminUser::className(), ['user_guid'=>'user_guid']);
    }
    
  
}
