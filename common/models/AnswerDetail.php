<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "answer_detail".
 *
 * @property string $id
 * @property string $answer_guid
 * @property string $task_guid
 * @property string $question_guid
 * @property string $user_guid
 * @property integer $code
 * @property integer $type
 * @property string $answer
 * @property string $path
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 */
class AnswerDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_guid', 'task_guid', 'question_guid', 'user_guid'], 'string'],
            [['code', 'type', 'created_at', 'updated_at'], 'integer'],
            [['answer'], 'string', 'max' => 255],
            [['path', 'photo'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answer_guid' => 'Answer Guid',
            'task_guid' => 'Task Guid',
            'question_guid' => 'Question Guid',
            'user_guid' => 'User Guid',
            'code' => '题目编号',
            'type' => '题目类型',
            'answer' => '答案',
            'path' => 'Path',
            'photo' => 'Photo',
            'created_at' => '提交时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
    
    public function getQuestion(){
        return $this->hasOne(Question::className(), ['question_guid'=>'question_guid']);
    }
}
