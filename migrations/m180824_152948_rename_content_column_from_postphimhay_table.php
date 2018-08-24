<?php

use yii\db\Migration;

/**
 * Class m180824_152948_rename_content_column_from_postphimhay_table
 */
class m180824_152948_rename_content_column_from_postphimhay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('postphimhay', 'content', 'attributes');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180824_152948_rename_content_column_from_postphimhay_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180824_152948_rename_content_column_from_postphimhay_table cannot be reverted.\n";

        return false;
    }
    */
}
