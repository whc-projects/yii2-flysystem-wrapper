<?php

namespace whc\flysystemwrapper\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%file_storage}}".
 *
 * @property integer $id
 * @property string $path
 * @property string $type
 * @property resource $contents
 * @property integer $size
 * @property string $mimetype
 * @property integer $timestamp
 * @property string $deleted_time
 *
 * @property File[] $files
 */
class FileStorage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file_storage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'type'], 'required' , 'except' => 'getByParams'],
            [['contents'], 'string'],
            [['size', 'timestamp'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 15],
            [['mimetype'], 'string', 'max' => 127],
            [['path'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'path' => Yii::t('app', 'Path'),
            'type' => Yii::t('app', 'Type'),
            'contents' => Yii::t('app', 'Contents'),
            'size' => Yii::t('app', 'Size'),
            'mimetype' => Yii::t('app', 'Mimetype'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['file_storage_id' => 'id']);
    }
}