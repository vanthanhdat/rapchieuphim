<?php

use yii\db\Migration;

/**
 * Handles adding views to table `postphimhay`.
 */
class m180829_044048_add_views_column_to_postphimhay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('postphimhay', 'views', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('postphimhay', 'views');
    }
}
