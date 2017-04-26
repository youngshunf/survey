<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "group_user".
 *
 * @property string $id
 * @property string $group_id
 * @property string $user_guid
 * @property string $created_at
 */
class GroupUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'created_at'], 'integer'],
            [['user_guid'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'user_guid' => 'User Guid',
            'created_at' => 'Created At',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
