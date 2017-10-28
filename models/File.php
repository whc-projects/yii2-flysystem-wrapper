<?php
namespace whc\flysystemwrapper\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property integer $id
 * @property integer $file_storage_id
 * @property string $file_name
 * @property string $path
 * @property integer $size
 * @property string $mime_type
 * @property string $context
 * @property integer $version
 * @property string $hash
 * @property string $uploaded_time
 * @property integer $uploaded_user_id
 * @property string $deleted_time
 *
 * @property FileStorage $fileStorage
 * @property User $uploadedUser
 * @property FileMetadata[] $fileMetadatas
 */
class File extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_name', 'path', 'size', 'mime_type', 'hash'], 'required' , 'except' => 'getByParams'],
            [['size', 'version', 'uploaded_user_id'], 'integer'],
            [['uploaded_time', 'deleted_time'], 'safe'],
            [['file_name', 'path'], 'string', 'max' => 255],
            [['mime_type'], 'string', 'max' => 25],
            [['context'], 'string', 'max' => 100],
            [['hash'], 'string', 'max' => 64],
            [['path'], 'unique'],
            [['hash'], 'unique'],
            [['uploaded_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uploaded_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_name' => Yii::t('app', 'File Name'),
            'path' => Yii::t('app', 'Path'),
            'size' => Yii::t('app', 'Size'),
            'mime_type' => Yii::t('app', 'Mime Type'),
            'context' => Yii::t('app', 'Context'),
            'version' => Yii::t('app', 'Version'),
            'hash' => Yii::t('app', 'Hash'),
            'uploaded_time' => Yii::t('app', 'Uploaded Time'),
            'uploaded_user_id' => Yii::t('app', 'Uploaded User ID'),
            'deleted_time' => Yii::t('app', 'Deleted Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUploadedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uploaded_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileMetadatas()
    {
        return $this->hasMany(FileMetadata::className(), ['file_id' => 'id']);
    }
}