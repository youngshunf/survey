<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "income_rec".
 *
 * @property string $id
 * @property string $user_guid
 * @property string $amount
 * @property string $task_guid
 * @property string $remark
 * @property string $answer_guid
 * @property string $created_at
 */
class IncomeRec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income_rec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guid', 'task_guid', 'answer_guid'], 'string'],
            [['amount'], 'number'],
            [['created_at'], 'integer'],
            [['remark'], 'string', 'max' => 255]
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
            'amount' => '收入金额',
            'task_guid' => 'Task Guid',
            'remark' => '备注',
            'answer_guid' => 'Answer Guid',
            'created_at' => '时间',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
