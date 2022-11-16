<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\search\AnuntSearch $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\AnuntController $localitati */
/** @var \frontend\controllers\AnuntController $departamente */
?>
<?php
    $localitati_map=ArrayHelper::map($localitati,'oras','oras');
    $departamente_map=ArrayHelper::map($departamente,'departament','departament');
?>
<div class="anunt-search">


    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php  echo $form->field($model, 'oras')->dropDownList($localitati_map,['prompt'=>'']);?>

    <?php echo $form->field($model, 'departament')->dropDownList($departamente_map,['prompt'=>'']); ?>

    <?php // echo $form->field($model, 'cale_imagine') ?>

    <div class="form-group">
        <?= Html::submitButton('Cauta', ['class' => 'btn btn-primary']) ?>
        <?php //echoHtml::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
