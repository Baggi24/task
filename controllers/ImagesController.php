<?php

namespace app\controllers;

use app\models\custom\Images;
use yii\web\Controller;

class ImagesController extends Controller {

	public function actionView(){
		$view = Images::run("100,200x300,500x600,600x700,300");
		return $this->render('view', compact('view'));
	}


}