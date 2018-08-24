<?php

use yii\db\Migration;

/**
 * Handles the creation of table `postphimhay`.
 */
class m180824_060041_create_postphimhay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('postphimhay', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('postphimhay');
    }
}
