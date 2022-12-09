<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\CandidatFisierSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="candidat-fisier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cale_fisier') ?>

    <?= $form->field($model, 'data_adaugare') ?>

    <?= $form->field($model, 'descriere') ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_post') ?>

    <?php // echo $form->field($model, 'id_user_adaugare') ?>

    <?php // echo $form->field($model, 'nume_fisier_afisare') ?>

    <?php // echo $form->field($model, 'nume_fisier_adaugare') ?>

    <?php // echo $form->field($model, 'id_nom_tip_fisier_dosar') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
