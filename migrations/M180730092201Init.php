<?php

namespace wmsamolet\fcs\core\migrations;

use yii\db\Migration;

/**
 * Class M180730092201Init
 */
class M180730092201Init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%fcs_entity}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull()->defaultValue(0),
            'title' => $this->string()->notNull(),
            'class' => $this->string()->notNull(),
            'table' => $this->string()->notNull(),
            'categories_table' => $this->string(),
            'slug_attribute' => $this->string(),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%fcs_entity_group}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%fcs_handler}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string()->notNull(),
            'function' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%fcs_event}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%fcs_event_handler}}', [
            'event_id' => $this->integer()->notNull(),
            'handler_id' => $this->integer()->notNull(),
            'description' => $this->string()->notNull(),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('','{{%fcs_event_handler}}', ['event_id', 'handler_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fcs_entity}}');
        $this->dropTable('{{%fcs_entity_group}}');
        $this->dropTable('{{%fcs_handler}}');
        $this->dropTable('{{%fcs_event}}');
        $this->dropTable('{{%fcs_event_handler}}');
    }
}
