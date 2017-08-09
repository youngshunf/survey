<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "withdraw_rec".
 *
 * @property string $id
 * @property string $user_guid
 * @property string $auth_user
 * @property string $amount
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class WithdrawRec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'withdraw_rec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guid', 'auth_user'], 'string'],
            [['amount'], 'number'],
            [['status', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => '提现用户',
            'auth_user' => '审核用户',
            'amount' => '提现金额',
            'status' => '状态',
            'created_at' => '申请时间',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
