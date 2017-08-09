<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "template_question".
 *
 * @property string $id
 * @property integer $type
 * @property string $name
 * @property string $desc
 * @property integer $code
 * @property string $options
 * @property string $qrcode_value
 * @property string $created_at
 * @property string $updated_at
 * @property integer $max_photo
 * @property integer $required
 * @property string $templateno
 * @property string $user_guid
 */
class TemplateQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'code', 'created_at', 'updated_at', 'max_photo', 'required'], 'integer'],
            [['options', 'user_guid'], 'string'],
            [['name', 'desc', 'qrcode_value'], 'string', 'max' => 255],
            [['templateno'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '问题类型',
            'name' => '问题名称',
            'desc' => 'Desc',
            'code' => '问题编号',
            'options' => '选项',
            'qrcode_value' => '二维码值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'max_photo' => '照片数量',
            'required' => '是否必填',
            'templateno' => '模板编号',
            'user_guid' => 'User Guid',
        ];
    }
}
