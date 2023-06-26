<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomNivelStudii $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */


Dialog::widget();
DialogAsset::register($this);

$form = ActiveForm::begin();
echo $form->field($model, 'nume')->textInput();
echo Html::submitButton('Actualizează', ['class' => 'btn btn-success']);
ActiveForm::end();
