<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_wallet".
 *
 * @property string $id
 * @property string $user_guid
 * @property integer $charge_type
 * @property string $balance
 * @property string $frozen_amount
 * @property string $total_amount
 * @property string $created_at
 * @property string $updated_at
 */
class AdminWallet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_wallet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guid'], 'string'],
            [['charge_type', 'created_at', 'updated_at'], 'integer'],
            [['balance', 'frozen_amount', 'total_amount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => 'User Guid',
            'charge_type' => '充值方式',
            'balance' => '账户余额',
            'frozen_amount' => '冻结金额',
            'total_amount' => '累计充值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(AdminUser::className(), ['user_guid'=>'user_guid']);
    }
}
