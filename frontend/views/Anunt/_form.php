<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Anunt $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="anunt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user_adaugare')->textInput() ?>

    <?= $form->field($model, 'data_postare')->textInput() ?>

    <?= $form->field($model, 'data_concurs')->textInput() ?>

    <?= $form->field($model, 'data_depunere_dosar')->textInput() ?>

    <?= $form->field($model, 'departament')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titlu')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
