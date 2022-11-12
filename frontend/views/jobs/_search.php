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

    <?= $form->field($model, 'Denumire')->textInput(array('placeholder' => 'search'))->label(false);?>

    <?php ActiveForm::end(); ?>

</div>
