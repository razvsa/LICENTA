<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\AnuntSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="anunt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_user_adaugare') ?>

    <?= $form->field($model, 'data_postare') ?>

    <?= $form->field($model, 'data_concurs') ?>

    <?= $form->field($model, 'data_depunere_dosar') ?>

    <?php // echo $form->field($model, 'oras') ?>

    <?php // echo $form->field($model, 'departament') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
