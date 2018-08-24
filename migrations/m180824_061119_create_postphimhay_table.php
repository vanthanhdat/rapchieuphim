<?php

use yii\db\Migration;

/**
 * Handles the creation of table `postphimhay`.
 */
class m180824_061119_create_postphimhay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('postphimhay', [
            'id' => $this->primaryKey(),
            'attributes' => 'LONGTEXT',
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
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
