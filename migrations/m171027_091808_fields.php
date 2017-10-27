<?php

use yii\db\Migration;

class m171027_091808_fields extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%field}}', [
            'id' => $this->primaryKey(),
            'cat' => $this->string(20)->notNull(),
            'alias' => $this->string(20),
            'pos' => $this->integer(),
            'status' => $this->smallInteger(1)->defaultValue(1),
            'type' => $this->string(20)->notNull(),
            'plugin' => $this->string(100),
            'multi' => $this->smallInteger(1)->defaultValue(0),
            'directory_class' => $this->string(100),
            'name' => $this->string(255)->notNull(),
            'unit' => $this->string(10),
            'counter' => $this->integer()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('cat', '{{%field}}', 'cat', false);
        $this->createIndex('alias', '{{%field}}', 'alias', true);
        $this->createIndex('name', '{{%field}}', 'name', true);

        $this->createTable('{{%field_string}}', [
            'id' => $this->primaryKey(),
            'cat' => $this->string(20)->notNull(),
            'time' => $this->timestamp()->null(),
            'field_id' => $this->integer(),
            'item_id' => $this->integer(),
            'value' => $this->text(),
        ], $tableOptions);

        $this->createIndex('cat', '{{%field_string}}', 'cat', false);
        $this->createIndex('time_item', '{{%field_string}}', ['time', 'item_id'], false);
        $this->createIndex('time_field_item', '{{%field_string}}', ['time', 'field_id', 'item_id'], false);
        $this->createIndex('time_field_value', '{{%field_string}}', ['time', 'field_id', 'value'], false);
        $this->addForeignKey('fk_field_string_field', '{{%field_string}}', 'field_id', '{{%field}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%field_text}}', [
            'id' => $this->primaryKey(),
            'cat' => $this->string(20)->notNull(),
            'time' => $this->timestamp()->null(),
            'field_id' => $this->integer(),
            'item_id' => $this->integer(),
            'value' => $this->text(),
        ], $tableOptions);

        $this->createIndex('cat', '{{%field_text}}', 'cat', false);
        $this->createIndex('time_item', '{{%field_text}}', ['time', 'item_id'], false);
        $this->createIndex('time_field_item', '{{%field_text}}', ['time', 'field_id', 'item_id'], false);
        $this->createIndex('time_field_value', '{{%field_text}}', ['time', 'field_id', 'value'], false);
        $this->addForeignKey('field_text_field', '{{%field_text}}', 'field_id', '{{%field}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%field_int}}', [
            'id' => $this->primaryKey(),
            'cat' => $this->string(20)->notNull(),
            'time' => $this->timestamp()->null(),
            'field_id' => $this->integer(),
            'item_id' => $this->integer(),
            'value' => $this->float(),
        ], $tableOptions);

        $this->createIndex('cat', '{{%field_int}}', 'cat', false);
        $this->createIndex('time_item', '{{%field_int}}', ['time', 'item_id'], false);
        $this->createIndex('time_field_item', '{{%field_int}}', ['time', 'field_id', 'item_id'], false);
        $this->createIndex('time_field_value', '{{%field_int}}', ['time', 'field_id', 'value'], false);
        $this->addForeignKey('field_int_field', '{{%field_int}}', 'field_id', '{{%field}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%field_directory}}', [
            'id' => $this->primaryKey(),
            'cat' => $this->string(20)->notNull(),
            'time' => $this->timestamp()->null(),
            'field_id' => $this->integer(),
            'item_id' => $this->integer(),
            'plugin_data' => $this->text(),
            'value' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('cat', '{{%field_directory}}', 'cat', false);
        $this->createIndex('time_item', '{{%field_directory}}', ['time', 'item_id'], false);
        $this->createIndex('time_field_item', '{{%field_directory}}', ['time', 'field_id', 'item_id'], false);
        $this->createIndex('time_field_value', '{{%field_directory}}', ['time', 'field_id', 'value'], false);
        $this->addForeignKey('field_directory_field', '{{%field_directory}}', 'field_id', '{{%field}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%field_string}}');
        $this->dropTable('{{%field_text}}');
        $this->dropTable('{{%field_int}}');
        $this->dropTable('{{%field_directory}}');
        $this->dropTable('{{%field}}');
    }
}
