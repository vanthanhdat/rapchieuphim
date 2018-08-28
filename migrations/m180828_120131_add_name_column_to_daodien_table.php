<?php

use yii\db\Migration;

/**
 * Handles adding name to table `daodien`.
 */
class m180828_120131_add_name_column_to_daodien_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('daodien', 'name', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('daodien', 'name');
    }
}
