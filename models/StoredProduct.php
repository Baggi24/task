<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stored_product".
 *
 * @property int $id
 * @property int $store_id
 * @property string $upc
 * @property string|null $title
 * @property float|null $price
 *
 * @property Store $store
 */
class StoredProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stored_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'upc'], 'required'],
            [['store_id'], 'integer'],
            [['price'], 'number'],
            [['upc', 'title'], 'string', 'max' => 255],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'upc' => 'Upc',
            'title' => 'Title',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Store]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }
}
