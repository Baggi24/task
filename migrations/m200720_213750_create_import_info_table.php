<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%import_info}}`.
 */
class m200720_213750_create_import_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%import_info}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(),
            'store' => $this->string(),
            'success' => $this->integer(),
            'fail' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%import_info}}');
    }
}
