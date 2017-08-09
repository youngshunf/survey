<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property string $id
 * @property string $user_guid
 * @property string $name
 * @property integer $tasknum
 * @property string $created_at
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guid'], 'string'],
            [['tasknum', 'created_at'], 'integer'],
            [['name','shop'], 'string', 'max' => 255]
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
            'name' => '项目名称',
            'shop'=>'门店渠道',
            'tasknum' => '任务个数',
            'created_at' => '创建时间',
        ];
    }
}
