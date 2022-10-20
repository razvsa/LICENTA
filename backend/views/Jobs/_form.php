<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Jobs $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>

<div class="jobs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Denumire')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Oras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Departament')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Tip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Nivel_studii')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Nivel_cariera')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Salariu')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
