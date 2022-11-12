<?php

use common\models\Jobs;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Jobs $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>

<div class="jobs-form">

    <?php $form = ActiveForm::begin([
            'options'=>['enctype'=>'multipart/form-data']
    ]);
    $dataProvider=new ActiveDataProvider([
        'query'=>Jobs::find()
    ]);
    $ceva=['var1'=>'variabila','var2'=>'variabila2'];
    $vector=['valoare1','valoare2'];
   //$result=\yii\helpers\ArrayHelper::setValue($vector,'value');
    ?>

    <?php
    $a=3;
    $b=7;
    if($a>$b)
       echo $form->field($model, 'Denumire')->dropdownList([
            'ramane de facut'=>'ramane de facut']);
    else
       echo $form->field($model, 'Denumire')->textInput(['maxlength' => true]);

    ?>

    <?= $form->field($model,'Oras')->dropdownList(
            $ceva,  ['prompt'=>'Choose...'])
  ?>

    <?= $form->field($model, 'Departament')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Tip')->dropdownList([
            'full time'=>'full time',
            'full time-remote'=>'full time-remote',
            'part time'=>'part-time',
            'part time-remote'=>'part time-remote'
    ]) ?>

    <?= $form->field($model, 'Nivel_studii')->textInput()?>

    <?= $form->field($model, 'Nivel_studii')->textInput(); ?>
    <?= $form->field($model, 'Nivel_studii')->textInput()
        ->label('Description'); ?>
    <?= $form->field($model, 'Nivel_studii')->textInput(); ?>


    <?=
    $form->field($model, 'Nivel_cariera')->dropdownList([
            'incepator'=>'incepator',
            '0-2 ani'=>'0-2 ani',
            '2-5 ani'=>'2-5 ani',
            '5-10 ani'=>"5-10 ani",
            '10+'=>'10+'
    ])
        ?>

    <?= $form->field($model, 'Salariu')->textInput() ?>

    Imagine
    <br>
    <input type="file" id="imageFile" name="image">
    <br>

    <div class="form-group">
        <br>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
