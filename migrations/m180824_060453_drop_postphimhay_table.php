<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `postphimhay`.
 */
class m180824_060453_drop_postphimhay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('postphimhay');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('postphimhay', [
            'id' => $this->primaryKey(),
            '=',
        ]);
    }
}
