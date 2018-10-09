<?php

use yii\db\Migration;

/**
 * Handles adding active to table `city`.
 */
class m181009_053207_add_active_column_to_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('city', 'active', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('city', 'active');
    }
}
