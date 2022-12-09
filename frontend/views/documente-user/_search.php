<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\DocumnteUserSearch $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\DocumenteUserController $document */
?>

<div class="documente-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'CV') ?>

    <?= $form->field($model, 'diploma_bacalaureat') ?>

    <?= $form->field($model, 'diploma_licenta') ?>

    <?= $form->field($model, 'diploma_master') ?>

    <?php // echo $form->field($model, 'act_identitate') ?>

    <?php // echo $form->field($model, 'carnet_munca') ?>

    <?php // echo $form->field($model, 'adeaverinta_vechime_munca') ?>

    <?php // echo $form->field($model, 'livret_militar') ?>

    <?php // echo $form->field($model, 'certificat_nastere') ?>

    <?php // echo $form->field($model, 'certificat_casatorie') ?>

    <?php // echo $form->field($model, 'certificat_nastere_partener') ?>

    <?php // echo $form->field($model, 'certificat_nastere_copii') ?>

    <?php // echo $form->field($model, 'autobiografie') ?>

    <?php // echo $form->field($model, 'tabel_nominal_rude') ?>

    <?php // echo $form->field($model, 'cazier') ?>

    <?php // echo $form->field($model, 'fotografie') ?>

    <?php // echo $form->field($model, 'adeverinta_medic_familie') ?>

    <?php // echo $form->field($model, 'consintamant_informat') ?>

    <?php // echo $form->field($model, 'aviz_psihologic') ?>

    <?php // echo $form->field($model, 'declaratie_de_conformitate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
