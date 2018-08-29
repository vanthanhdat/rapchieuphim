<?php

use yii\db\Migration;

/**
 * Handles adding views to table `postreview`.
 */
class m180829_044156_add_views_column_to_postreview_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('postreview', 'views', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('postreview', 'views');
    }
}
