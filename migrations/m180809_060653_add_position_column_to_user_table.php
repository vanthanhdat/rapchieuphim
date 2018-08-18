<?php

use yii\db\Migration;

/**
 * Handles adding position to table `user`.
 */
class m180809_060653_add_position_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'position', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'position');
    }
}
