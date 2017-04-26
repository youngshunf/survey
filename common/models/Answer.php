<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property string $id
 * @property string $task_guid
 * @property string $user_guid
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 * @property string $answer
 * @property string $created_at
 * @property string $updated_at
 * @property integer $first_auth
 * @property string $first_auth_user
 * @property string $first_auth_remark
 * @property integer $second_auth
 * @property string $second_auth_user
 * @property string $second_auth_remark
 * @property string $post_user
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_guid', 'user_guid', 'first_auth_user', 'first_auth_remark', 'second_auth_user', 'second_auth_remark', 'post_user'], 'string'],
            [['start_time', 'end_time', 'status', 'created_at', 'updated_at', 'first_auth', 'second_auth'], 'integer']
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
            'user_guid' => 'User Guid',
            'start_time' => '领取任务时间',
            'end_time' => '提交任务时间',
            'status' => '任务状态',
            'answer' => '答案',
            'created_at' => '提交时间',
            'updated_at' => '修改时间',
            'first_auth' => '一审',
            'first_auth_user' => '一审用户',
            'first_auth_remark' => '一审意见',
            'second_auth' => '二审',
            'second_auth_user' => '二审用户',
            'second_auth_remark' => '二审意见',
            'post_user' => '任务发布者',
            'start_address'=>'领取任务地点',
            'submit_address'=>'提交任务地点',
            
            
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
    public function getTask(){
        return $this->hasOne(Task::className(), ['task_guid'=>'task_guid']);
    }
}
