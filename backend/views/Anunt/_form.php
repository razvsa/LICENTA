<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
/** @var yii\web\View $this */
/** @var common\models\Anunt $model */
/** @var yii\bootstrap4\ActiveForm $form */

?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

<div class="anunt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data_concurs')->widget(DateTimePicker::className(),[
            'language' => 'ro',
            'pluginOptions' =>[
            'startDate' => date('Y-m-d H:i:s'),
            'autoclose'=>true,
        ],

    ]);?>

    <?= $form->field($model, 'data_depunere_dosar')->widget(DateTimePicker::className(),[
            'language' => 'ro',
            'pluginOptions' =>['startDate' => date('Y-m-d H:i:s'),
            'autoclose'=>true,
        ],

    ]);?>
    <?= $form->field($model, 'data_limita_inscriere_concurs')->widget(DateTimePicker::className(),[
            'language' => 'ro',
            'pluginOptions' =>['startDate' => date('Y-m-d H:i:s'),
            'autoclose'=>true,
        ],


    ]);?>


    <?= $form->field($model, 'departament')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descriere')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <br>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
