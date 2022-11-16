<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-vacant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'id_nom_tip_functie')->textInput() ?>

    <?= $form->field($model, 'pozitie_stat_organizare')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'denumire')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cerinte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_nom_judet')->textInput() ?>

    <?= $form->field($model, 'id_nom_nivel_studii')->textInput() ?>

    <?= $form->field($model, 'id_nom_nivel_cariera')->textInput() ?>

    <?= $form->field($model, 'Oras')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
