<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%store_product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 */
class m200716_133303_create_store_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%store_product}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'product_image' => $this->string(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-store_product-product_id}}',
            '{{%store_product}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-store_product-product_id}}',
            '{{%store_product}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-store_product-product_id}}',
            '{{%store_product}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-store_product-product_id}}',
            '{{%store_product}}'
        );

        $this->dropTable('{{%store_product}}');
    }
}
