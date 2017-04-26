<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wallet".
 *
 * @property string $id
 * @property string $user_guid
 * @property string $non-payment
 * @property string $paid
 * @property string $total_income
 * @property string $created_at
 * @property string $updated_at
 * @property string $withdrawing
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wallet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guid'], 'string'],
            [['non_payment', 'paid', 'total_income', 'withdrawing'], 'number'],
            [['created_at', 'updated_at'], 'integer']
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
            'non_payment' => '未提款',
            'paid' => '已提款',
            'total_income' => '累计收益',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'withdrawing' => '提现中',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
