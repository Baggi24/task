<?php
namespace app\models\custom;

use app\models\Store;
use app\models\StoredProduct;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model {

	/**
	 * @var UploadedFile
	 */
	public $csvFiles;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[['csvFiles'], 'file', 'checkExtensionByMimeType' => false,
               'skipOnEmpty' => false, 'extensions' => ['csv', 'xls', 'xlsx'], // 'mimeTypes' => 'text/plain',
               'maxFiles' => 4, 'maxSize' => 1024*1024*5, 'tooBig' => 'Max size is 5MB'],
		];
	}

	/**
	 * @return bool
	 */
	public function upload()
	{
		if ($this->validate()) {
			foreach ($this->csvFiles as $file) {
				$file->saveAs('../uploads/' . $file->baseName . '.' . $file->extension);
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return array
	 */
	public function getStores(){
		$stores =  Store::find()->select(['id','title'])->all();
		$result = [];
		foreach ($stores as $store){
			$result[$store['id']] = $store['title'];
		}

		return $result;
	}

	public function getProducts( $storeId, $upc){
		$product =  StoredProduct::find()
		                    ->select('upc')
		                    ->innerJoin('store', 'store.id = stored_product.store_id')
		                    ->where(['upc' => $upc])
							->andWhere(['store.id' => $storeId])
		                    ->one();

		return $product;
	}

//	public function insertCsvToDb(){
//		$rows[] = [
//			'store_id' => $store_id,
//			'upc' => $upc,
//			'title' => (isset($title)) ? $title : null,
//			'price' => (isset($price)) ? $price : null,
//		];
//
//
//			\Yii::$app->db->createCommand()
//			              ->batchInsert('stored_product',
//				              ['store_id', 'upc', 'title', 'price'],
//				              $rows
//			              )
//			              ->execute();
//
//	}
}