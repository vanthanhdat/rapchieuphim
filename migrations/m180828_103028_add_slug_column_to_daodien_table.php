<?php

use yii\db\Migration;

/**
 * Handles adding slug to table `daodien`.
 */
class m180828_103028_add_slug_column_to_daodien_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('daodien', 'slug', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('daodien', 'slug');
    }
}
