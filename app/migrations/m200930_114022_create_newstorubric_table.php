<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%newstorubric}}`.
 */
class m200930_114022_create_newstorubric_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%newstorubric}}', [
            'news_id' => $this->integer(),
            'rubric_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-newstorubric-news_id',
            'newstorubric',
            'news_id'
        );

        $this->addForeignKey(
            'fk-newstorubric-news_id',
            'newstorubric',
            'news_id',
            'news',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-newstorubric-rubric_id',
            'newstorubric',
            'rubric_id'
        );

        $this->addForeignKey(
            'fk-newstorubric-rubric_id',
            'newstorubric',
            'rubric_id',
            'rubric',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-newstorubric-rubric_id', 'newstorubric');
        $this->dropIndex('idx-newstorubric-rubric_id', 'newstorubric');
        $this->dropForeignKey('fk-newstorubric-news_id', 'newstorubric');
        $this->dropIndex('idx-newstorubric-news_id', 'newstorubric');
        $this->dropTable('{{%newstorubric}}');
    }
}
