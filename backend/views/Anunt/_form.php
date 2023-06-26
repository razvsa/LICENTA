<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use common\models\NomDepartament;
/** @var yii\web\View $this */
/** @var common\models\Anunt $model */
/** @var yii\bootstrap4\ActiveForm $form */

?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

<div class="anunt-form">

    <?php
    $departamente=NomDepartament::find()->all();
    $departamente_map=\yii\helpers\ArrayHelper::map($departamente,'id','nume');
    $categorie=\common\models\NomTipCategorie::find()->all();
    $categorie_map=\yii\helpers\ArrayHelper::map($categorie,'id','nume');
    $structura=\common\models\NomStructura::find()->all();
    $structura_map=\yii\helpers\ArrayHelper::map($structura,'id','nume');
    $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'titlu')->textInput();?>
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

    <?php
        if(Yii::$app->user->getIdentity()->admin==0)
            echo $form->field($model,'id_structura')->widget(Select2::className(),[
                'bsVersion'=>'4.x',
                'data'=>$structura_map,
                'options'=>[
                    'placeholder' => 'Selecteaza Structura'
                ],
            ])->label("Structura");

    ?>

    <?= $form->field($model, 'categorie_fisier')->dropdownList($categorie_map,[
        'prompt'=>'Selecteaza Categoria',
    ])?>

    <?= $form->field($model, 'descriere')->textarea(['maxlength' => true]) ?>



    <div class="form-group">
        <br>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();
//    $this->registerJs("
//    $(document).ready(function() {
//    $('#" . Html::getInputId($model, 'data_concurs') . "').on('change', function() {
//    var selectedDate = $(this).val();
//    $('#" . Html::getInputId($model, 'data_depunere_dosar') . "').datetimepicker('setStartDate', selectedDate);
//    });
//    });
//    ");
//    ?>
</div>
