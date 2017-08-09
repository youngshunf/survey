<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property string $group_id
 * @property string $create_by
 * @property string $group_name
 * @property string $created_at
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_by'], 'string'],
            [['created_at'], 'integer'],
            [['group_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => '分组ID',
            'create_by' => '所属用户',
            'group_name' => '分组名',
            'created_at' => '创建时间',
        ];
    }
}
