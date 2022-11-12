<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\JobsSearch $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>

<div class="jobs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Denumire') ?>

    <?= $form->field($model, 'Oras') ?>

    <?= $form->field($model, 'Departament') ?>

    <?= $form->field($model, 'Tip') ?>

    <?php // echo $form->field($model, 'Nivel_studii') ?>

    <?php // echo $form->field($model, 'Nivel_cariera') ?>

    <?php // echo $form->field($model, 'Salariu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
