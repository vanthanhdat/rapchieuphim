<?php

use yii\db\Migration;

/**
 * Handles adding views to table `daodien`.
 */
class m180829_043930_add_views_column_to_daodien_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('daodien', 'views', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('daodien', 'views');
    }
}
