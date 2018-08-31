<?php

use yii\db\Migration;

/**
 * Handles adding slug to table `phim`.
 */
class m180831_041908_add_slug_column_to_phim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('phim', 'slug', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('phim', 'slug');
    }
}
