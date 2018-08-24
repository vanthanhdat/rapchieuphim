<?php

use yii\db\Migration;

/**
 * Handles the creation of table `postreview`.
 * Has foreign keys to the tables:
 *
 * - `phim`
 */
class m180824_121348_create_postreview_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('postreview', [
            'id' => $this->primaryKey(),
            'phim_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'attributes' => 'LONGTEXT',
        ]);

        // creates index for column `phim_id`
        $this->createIndex(
            'idx-postreview-phim_id',
            'postreview',
            'phim_id'
        );

        // add foreign key for table `phim`
        $this->addForeignKey(
            'fk-postreview-phim_id',
            'postreview',
            'phim_id',
            'phim',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `phim`
        $this->dropForeignKey(
            'fk-postreview-phim_id',
            'postreview'
        );

        // drops index for column `phim_id`
        $this->dropIndex(
            'idx-postreview-phim_id',
            'postreview'
        );

        $this->dropTable('postreview');
    }
}
