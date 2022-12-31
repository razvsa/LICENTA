<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\CandidatFisier $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="candidat-fisier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cale_fisier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_adaugare')->textInput() ?>

    <?= $form->field($model, 'descriere')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_user_adaugare')->textInput() ?>

    <?= $form->field($model, 'nume_fisier_afisare')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nume_fisier_adaugare')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_nom_tip_fisier_dosar')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
