<?php

use yii\db\Migration;

/**
 * Handles dropping title from table `postphimhay`.
 */
class m180824_152615_drop_title_column_from_postphimhay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('postphimhay', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('postphimhay', 'title', $this->string());
    }
}
