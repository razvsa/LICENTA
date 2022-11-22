<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\PostVacantSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-vacant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_nom_tip_functie') ?>

    <?= $form->field($model, 'pozitie_stat_organizare') ?>

    <?= $form->field($model, 'denumire') ?>

    <?= $form->field($model, 'cerinte') ?>

    <?php // echo $form->field($model, 'id_nom_judet') ?>

    <?php // echo $form->field($model, 'id_nom_nivel_studii') ?>

    <?php // echo $form->field($model, 'id_nom_nivel_cariera') ?>

    <?php // echo $form->field($model, 'oras') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
