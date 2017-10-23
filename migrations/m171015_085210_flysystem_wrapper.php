<?php

use yii\db\Migration;

/**
 * Class m171015_085210_filemanager
 * php yii migrate/up --migrationPath=@education/runtime/tmp-extensions/yii2-file-manager/migrations
 */
class m171015_085210_flysystem_wrapper extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(255)->notNull(),
            'path' => $this->string(255)->notNull(),
            'size' => $this->integer()->notNull(),
            'mime_type' => $this->string(25)->notNull(),
            'context' => $this->string(100)->null(),
            'version' => $this->integer()->null(),
            'hash' => $this->string(64)->notNull(),
            'uploaded_time' => $this->timestamp(),
            'uploaded_user_id' => $this->integer(),
            'deleted_time' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%file_metadata}}', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer()->notNull(),
            'metadata' => $this->string(255)->notNull(),
            'value' => $this->string(255)->notNull(),
            'created_time' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%file_storage}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string(255)->notNull()->unique(),
            'type' => $this->string(15)->notNull(),
            'contents' => 'LONGBLOB',
            'size' => $this->integer()->notNull()->defaultValue(0),
            'mimetype' => $this->string(127),
            'timestamp' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->addForeignKey('fk_file_metadata', '{{%file_metadata}}', 'file_id', '{{%file}}', 'id');
        $this->addForeignKey('fk_file_uploaded_user_id', '{{%file}}', 'uploaded_user_id', '{{%user}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%file_metadata}}');
        $this->dropTable('{{%file}}');
        $this->dropTable('{{%file_storage}}');
    }
}
