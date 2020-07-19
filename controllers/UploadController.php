<?php

namespace app\controllers;

use app\models\Store;
use yii\db\Exception;
use yii\web\Controller;
use Yii;
use app\models\custom\UploadForm;
use yii\web\UploadedFile;

class UploadController extends Controller {

	public function actionIndex()
	{
		$request = Yii::$app->request;
		$model = new UploadForm();
		$store = $model->getStores();

		if ($request->isPost) {
			$selectedStore = $request->post('store');
			$model->csvFiles = UploadedFile::getInstances($model, 'csvFiles');
			if ($model->upload()) {
//				echo 'file is uploaded successfully';

				$cvsFiles = $model['csvFiles'];

				foreach ($cvsFiles as $cvs_file){


//					$csvFile = file("../uploads/{$cvs_file->name}");
//					$data = [];
//					foreach ($csvFile as $line) {
//						$data[] = str_getcsv($line);
//					}
//echo '<pre>';
//					print_r($data);exit;


//$array = [];
				$row = 1;
				if (($handle = fopen("../uploads/{$cvs_file->name}", "r")) !== FALSE) {

					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
						$num = count($data);

						if(!in_array('upc', $data)){
							new Exception('upc is required');
						}
						$upcKey = array_search('upc', $data);
						$title = array_search('title', $data);
						$price = array_search('price', $data);

//						$upc = '';
//						if($data[$upcKey] !== 'upc'){
//							$upc = $data[$upcKey];
//						}

						$array[] = $data[$upcKey];

						$row++;
						for ($c=0; $c < $num; $c++) {

//						print_r($data[$upcKey]);exit;
							$upc = '';
							if($data[$c] !== 'upc' && $upcKey === $c){
								echo $upc = $data[$upcKey];
							}
//							echo $data[$upcKey] . "<br />\n";

//							$test = $model->getProducts($selectedStore, $ups);

							$rows[] = [
								'store_id' => $selectedStore,
								'upc' => $data[$upcKey],
								'title' => (isset($title)) ? $title : null,
								'price' => (isset($price)) ? $price : null,
							];


//							\Yii::$app->db->createCommand()
//							              ->batchInsert('stored_product',
//								              ['store_id', 'upc', 'title', 'price'],
//								              $rows
//							              )
//							              ->execute();



						}
					}
					fclose($handle);

//					print_r($array);exit;
				}

				}







				return;
			}
		}

		return $this->render('index', ['model' => $model, 'store' => $store]);
	}

}