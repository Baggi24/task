<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "import_info".
 *
 * @property int $id
 * @property string|null $file_name
 * @property string|null $store
 * @property int|null $success
 * @property int|null $fail
 */
class ImportInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'import_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['success', 'fail'], 'integer'],
            [['file_name', 'store'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'store' => 'Store',
            'success' => 'Success',
            'fail' => 'Fail',
        ];
    }
}
