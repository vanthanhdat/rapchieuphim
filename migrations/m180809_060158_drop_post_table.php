<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `post`.
 */
class m180809_060158_drop_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('post');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
        ]);
    }
}
