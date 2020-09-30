<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rubric}}`.
 */
class m200930_110105_create_rubric_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rubric}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rubric}}');
    }
}
