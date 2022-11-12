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

    <?//echo  $form->field($model, 'id') ?>

    <?//echo  $form->field($model, 'id_user_adaugare') ?>

    <?//echo  $form->field($model, 'data_postare') ?>

    <?//echo  $form->field($model, 'data_concurs') ?>

    <?//echo  $form->field($model, 'data_depunere_dosar') ?>

    <?php  echo $form->field($model, 'oras') ?>

    <?php  echo $form->field($model, 'departament') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
