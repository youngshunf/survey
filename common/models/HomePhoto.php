<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "home_photo".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $path
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 */
class HomePhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'home_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'url', 'path', 'photo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'url' => 'Url',
            'path' => 'Path',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
