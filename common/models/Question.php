<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property string $id
 * @property string $task_guid
 * @property string $user_guid
 * @property string $question_guid
 * @property integer $type
 * @property string $name
 * @property string $desc
 * @property integer $code
 * @property string $options
 * @property string $qrcode_value
 * @property string $created_at
 * @property string $updated_at
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_guid', 'user_guid', 'question_guid', 'options'], 'string'],
            [['type', 'code'], 'integer'],
            [['name', 'desc', 'qrcode_value'], 'string', 'max' => 255]
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
            'question_guid' => 'Question Guid',
            'type' => '问题类型',
            'name' => '问题名称',
            'desc' => 'Desc',
            'code' => '问题编号',
            'options' => '选项',
            'qrcode_value' => '二维码值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
