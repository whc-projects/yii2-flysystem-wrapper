<?php

namespace whc\flysystemwrapper\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%file_metadata}}".
 *
 * @property integer $id
 * @property integer $file_id
 * @property string $metadata
 * @property string $value
 *
 * @property File $file
 */
class FileMetadata extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file_metadata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id', 'metadata', 'value'], 'required' , 'except' => 'getByParams'],
            [['file_id'], 'integer'],
            [['created_time', 'modified_time', 'deleted_time'], 'safe'],
            [['metadata', 'value'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'metadata' => Yii::t('app', 'Metadata'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }
}