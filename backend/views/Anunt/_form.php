<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
/** @var yii\web\View $this */
/** @var common\models\Anunt $model */
/** @var yii\bootstrap4\ActiveForm $form */

?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

<div class="anunt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data_concurs')->widget(DateTimePicker::className([
            //limba romana si format ro
    ]));?>

    <?= $form->field($model, 'data_depunere_dosar')->textInput() ?>

    <?= $form->field($model, 'id_nom_judet')->widget(Select2::className(),[
            'options'=>['id'=>'id_judet'],
            'bsVersion'=>'4.x',
            'data'=>\yii\helpers\ArrayHelper::map(\common\models\NomJudet::find()->orderBy('nume')->all(),'id','nume'),
    ]) ?>

    <?= $form->field($model, 'id_nom_localitate')->widget(DepDrop::classname(), [
        'options'=>['id'=>'id_localitate'],
        'type'=>DepDrop::TYPE_SELECT2,
        'pluginOptions'=>[
            'depends'=>['id_judet'],
            'placeholder'=>'',
            'url'=>Url::to(['/anunt/get-localitate'])
        ]
    ]) ?>

    <?= $form->field($model, 'departament')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cale_imagine')->textInput(['maxlength' => true]) ?>
<!---->
<!--    Imagine-->
<!--    <br>-->
<!--    <br>-->
<!--    <input type="file" id="imageFile" name="image">-->
<!--    <br>-->

    <div class="form-group">
        <br>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
