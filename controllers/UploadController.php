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
//				print_r($cvsFiles);exit;
				foreach ($cvsFiles as $cvs_file){

					$row = 1;
					if (($handle = fopen("../uploads/{$cvs_file->name}", "r")) !== FALSE) {

						$head = fgetcsv($handle, 1000, ',');

						$upcKey = array_search('upc', $head);
						$titleKey = array_search('title', $head);
						$priceKey = array_search('price', $head);

						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
							if(!is_numeric($upcKey)){
								throw new Exception("upc is required");
							}
							$upc = $data[$upcKey];
							$title = null;
							if(is_numeric($titleKey)){
								$title = $data[$titleKey];
							}
							$price = null;
							if(is_numeric($priceKey)){
								$price = $data[$priceKey];
							}

							$upcInStore = $model->getUpc($selectedStore, $upc);

							if(!isset($upcInStore)){

								$rows[] = [
									'store_id' => $selectedStore,
									'upc' => $upc,
									'title' => $title,
									'price' => $price,
								];

								\Yii::$app->db->createCommand()
								              ->batchInsert('stored_product',
									              ['store_id', 'upc', 'title', 'price'],
									              $rows
								              )
								              ->execute();
								$rows = [];
							}
							else{
								\Yii::$app->db->createCommand()
								              ->update('stored_product',
									              [ 'title'=>$title, 'price'=>$price ],
									              [ 'upc'=> $upcInStore ])
								              ->execute();
							}

							$row++;

						}

						fclose($handle);

					}

				}

				return;
			}
		}

		return $this->render('index', ['model' => $model, 'store' => $store]);
	}

}