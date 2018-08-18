<?php

use yii\db\Migration;

/**
 * Handles dropping position from table `user`.
 */
class m180809_061502_drop_position_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'position');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user', 'position', $this->integer());
    }
}
