<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `news`.
 */
class m180809_055935_drop_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('news');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
        ]);
    }
}
