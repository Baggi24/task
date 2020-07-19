<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stored_product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%store}}`
 */
class m200719_150920_create_stored_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stored_product}}', [
            'id' => $this->primaryKey(),
            'store_id' => $this->integer()->notNull(),
            'upc' => $this->string()->notNull(),
            'title' => $this->string(),
            'price' => $this->decimal(8,2),
        ]);

        // creates index for column `store_id`
        $this->createIndex(
            '{{%idx-stored_product-store_id}}',
            '{{%stored_product}}',
            'store_id'
        );

        // add foreign key for table `{{%store}}`
        $this->addForeignKey(
            '{{%fk-stored_product-store_id}}',
            '{{%stored_product}}',
            'store_id',
            '{{%store}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%store}}`
        $this->dropForeignKey(
            '{{%fk-stored_product-store_id}}',
            '{{%stored_product}}'
        );

        // drops index for column `store_id`
        $this->dropIndex(
            '{{%idx-stored_product-store_id}}',
            '{{%stored_product}}'
        );

        $this->dropTable('{{%stored_product}}');
    }
}
