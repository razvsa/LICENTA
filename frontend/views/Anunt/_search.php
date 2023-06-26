<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/** @var yii\web\View $this */
/** @var common\models\search\AnuntSearch $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\AnuntController $localitati */
/** @var \frontend\controllers\AnuntController $functie*/
/** @var \frontend\controllers\AnuntController $nivel_studii */
/** @var \frontend\controllers\AnuntController $nivel_cariera */

?>
<?php
    $functie_map=ArrayHelper::map($functie,'id','nume');
    $nivel_studii_map=ArrayHelper::map($nivel_studii,'id','nume');
    $nivel_cariera_map=ArrayHelper::map($nivel_cariera,'id','nume');



?>
<div class="anunt-search">


    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id'=>'anunt_search',
        'options'=>['data-pjax'=>true],
    ]);
    $model->oras="Tot Județul";

    ?>
    <div class="form-group">
        <?= Html::submitButton('Caută', ['class' => 'btn btn-primary']) ?>
        <?= Html::button('Resetează', ['class' => 'btn btn-outline-secondary', 'id' => 'reset-button']) ?>
    </div>
    <?php  echo $form->field($model, 'cuvant')->textInput([
        'id'=>'cuvant',
    ])->label('Caută...');?>



    <?php  echo $form->field($model, 'id_nom_tip_functie')->dropDownList($functie_map,[
            'id'=>'tip_functie',
            'prompt'=>"",
    ]);?>

    <?php echo $form->field($model, 'id_nom_nivel_studii')->dropDownList($nivel_studii_map,[
        'prompt'=>"",
        'id'=>'nivel_studii',
    ]); ?>

    <?php  echo $form->field($model, 'id_nom_nivel_cariera')->dropDownList($nivel_cariera_map,[
        'prompt'=>"",
        'id'=>'nivel_cariera',
    ]);?>



    <?php  echo $form->field($model, 'id_nom_judet')->widget(Select2::className(),[
        'options'=>[
            'id'=>'id_judet',
            'placeholder' => 'Alege Județul',

        ],
        'bsVersion'=>'4.x',
        'theme' => Select2::THEME_KRAJEE,

        'data'=>\yii\helpers\ArrayHelper::map(\common\models\NomJudet::find()
            ->innerJoin(['post'=>\common\models\PostVacant::tableName()],'post.id_nom_judet=nom_judet.id')
            ->orderBy('nume')->all(),'id','nume'),
    ]);?>

    <?php  echo $form->field($model, 'oras')->widget(DepDrop::className(),[
        'options'=>['id'=>'id_localitate'],
        'type'=>DepDrop::TYPE_SELECT2,
        'pluginOptions'=>[
            'depends'=>['id_judet'],
            'placeholder'=>'Tot Județul',

            'url'=>Url::to(['/anunt/get-localitate'])
        ]
    ]);?>




    <?php ActiveForm::end(); ?>

    <?php
    $date=Yii::$app->session->get('form');
    if(count($date)==0)
        $autoc=false;
    else
        $autoc=true;
    $this->registerJs("
$('#reset-button').click(function() {
    $('#cuvant').val('').trigger('change');
    $('#tip_functie').val('').trigger('change');
    $('#id_localitate').val('').trigger('change');
    $('#nivel_studii').val('').trigger('change');
    $('#nivel_cariera').val('').trigger('change');
    $('#id_judet').val('').trigger('change');
    $('#anunt_search').submit();
    
});

    var verifica=" . json_encode($autoc) . ";
    if(verifica==true){
        var anuntSearch = " . json_encode($date) . ";
        $('#tip_functie').val(anuntSearch.AnuntSearch.id_nom_tip_functie);
        $('#cuvant').val(anuntSearch.AnuntSearch.cuvant);
        $('#nivel_studii').val(anuntSearch.AnuntSearch.id_nom_nivel_studii);
        $('#nivel_cariera').val(anuntSearch.AnuntSearch.id_nom_nivel_cariera);
   }
");
    ?>
</div>
