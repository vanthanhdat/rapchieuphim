<?php

use yii\db\Migration;

/**
 * Handles dropping name from table `daodien`.
 */
class m180828_123423_drop_name_column_from_daodien_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('daodien', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('daodien', 'name', $this->text());
    }
}
