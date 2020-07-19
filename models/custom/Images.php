<?php

namespace app\models\custom;

use app\models\Product;
use yii\db\Exception;

class Images {

	/**
	 * @param $imageLink
	 * @param array $array
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function generateMiniature($imageLink, $array = ['width'=>500, 'height'=>400]){

		if(empty($imageLink) || !isset($imageLink)){
			throw new Exception("Wrong image link given");
		}
		if($array['width'] >= 500 || $array['height'] >= 400){
			throw new Exception("Image size's is too big");
		}

		$thumbLink = true;

		return $thumbLink;

	}

	/**
	 * @param $imageLink
	 * @param array $array
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function generateWatermarkedMiniature($imageLink, $array = ['width'=>500, 'height'=>400]){

		if(empty($imageLink) || !isset($imageLink)){
			throw new Exception("Wrong image link given");
		}
		if($array['width'] >= 500 || $array['height'] >= 400){
			throw new Exception("Image size's is too big");
		}

		$thumbLink = true;

		return $thumbLink;
	}

	/**
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getAllProducts(){
		$products =  Product::find()
		                 ->select('image')
		                 ->innerJoin('store_product', 'product.id = store_product.product_id')
		                 ->where(['is_deleted' => 0])
		                 ->asArray()
		                 ->all();

		return $products;
	}

	/**
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getOnlyProduct(){
		$products =  Product::find()
		                    ->select('image')
		                    ->where(['is_deleted' => 0])
		                    ->asArray()
		                    ->all();

		return $products;
	}

	/**
	 * @param $sizes
	 * @param bool $watermarked
	 * @param bool $catalogOnly
	 *
	 * @return string
	 */
	public static function run($sizes, $watermarked = false, $catalogOnly = true){

		if($catalogOnly === true){
			$links = self::getAllProducts();
		}
		else{
			$links = self::getOnlyProduct();
		}

		$generated = 0;
		$fail = 0;

		foreach ($links as $link){
			$thumbSizes = explode(',', $sizes);

			foreach ($thumbSizes as $thumbSize){
				if (strpos($thumbSize, 'x') === false) {
					$width = $thumbSize;
					$height = $thumbSize;
				}
				else{
					$t = explode('x', $thumbSize);
					$width = $t[0];
					$height = $t[1];
				}

				try{
					if($watermarked){
						$generate = self::generateWatermarkedMiniature($link['image'], ['width' => $width, 'height' => $height]);
					}
					else{
						$generate = self::generateMiniature($link['image'], ['width' => $width, 'height' => $height]);
					}

					if ($generate === true) {
						$generated++;
					}
				}catch(Exception $e){
					$fail++;
				}

			}

		}

		return "Generated Thumbnails = " . $generated . ' Failed = ' . $fail;

	}
}