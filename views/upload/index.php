<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= Html::dropDownList('store', '', $store, ['id' => 'store', 'class' => 'form-control']); ?>

<?= $form->field($model, 'csvFiles[]')->fileInput(['multiple' => true]) ?>

<button>Submit</button>

<?php ActiveForm::end() ?>
