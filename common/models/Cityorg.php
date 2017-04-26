<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cityorg".
 *
 * @property integer $id
 * @property string $pinyin
 * @property string $frameno
 * @property string $engineno
 * @property string $imgcode
 * @property string $province
 * @property string $city
 * @property string $lsprefix
 * @property string $lsnum
 */
class Cityorg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cityorg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pinyin'], 'string', 'max' => 32],
            [['frameno', 'engineno', 'imgcode', 'province', 'city', 'lsprefix', 'lsnum'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pinyin' => 'Pinyin',
            'frameno' => 'Frameno',
            'engineno' => 'Engineno',
            'imgcode' => 'Imgcode',
            'province' => 'Province',
            'city' => 'City',
            'lsprefix' => 'Lsprefix',
            'lsnum' => 'Lsnum',
        ];
    }
}
