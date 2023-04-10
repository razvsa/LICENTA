<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \common\models\NomNivelStudii $modelStudii */
?>


<?php
   $stud=\common\models\NomNivelStudii::find()->all();
   $stud_map=ArrayHelper::map($stud,'id','nume');
   $cariera=\common\models\NomNivelCariera::find()->all();
   $cariera_map=ArrayHelper::map($cariera,'id','nume');
   $functie=\common\models\NomTipIncadrare::find()->all();
   $functie_map=ArrayHelper::map($functie,'id','nume');
?>


<div class="post-vacant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_nom_tip_functie')->dropDownList($functie_map,[
            'placeholder'=>' '
    ])?>

    <?= $form->field($model, 'pozitie_stat_organizare')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'denumire')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cerinte')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'tematica')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'bibliografie')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_nom_judet')->widget(Select2::className(),[
        'options'=>[
            'id'=>'id_judet',
            'placeholder' => 'Alege Judetul'
        ],
        'bsVersion'=>'4.x',
        'data'=>\yii\helpers\ArrayHelper::map(\common\models\NomJudet::find()->orderBy('nume')->all(),'id','nume'),
    ]) ?>

    <?= $form->field($model, 'oras')->widget(DepDrop::className(),[
        'options'=>['id'=>'id_localitate'],
        'type'=>DepDrop::TYPE_SELECT2,
        'pluginOptions'=>[
            'depends'=>['id_judet'],
            'placeholder'=>'',
            'url'=>Url::to(['/anunt/get-localitate'])
        ]
    ]) ?>

    <?= $form->field($model, 'id_nom_nivel_studii')->dropDownList($stud_map)?>

    <?= $form->field($model, 'id_nom_nivel_cariera')->dropDownList($cariera_map) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
