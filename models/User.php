<?php
namespace whc\filemanager\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
}