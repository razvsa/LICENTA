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
    $model->oras="Tot Judetul";
    ?>

    <?php  echo $form->field($model, 'id_nom_tip_functie')->dropDownList($functie_map,[
            'prompt'=>"",
    ]);?>

    <?php echo $form->field($model, 'id_nom_nivel_studii')->dropDownList($nivel_studii_map,[
        'prompt'=>"",
    ]); ?>

    <?php  echo $form->field($model, 'id_nom_nivel_cariera')->dropDownList($nivel_cariera_map,[
        'prompt'=>"",
    ]);?>

    <?php  echo $form->field($model, 'id_nom_judet')->widget(Select2::className(),[
        'options'=>[
            'id'=>'id_judet',
            'placeholder' => 'Alege Judetul'
        ],
        'bsVersion'=>'4.x',
        'data'=>\yii\helpers\ArrayHelper::map(\common\models\NomJudet::find()
            ->innerJoin(['post'=>\common\models\PostVacant::tableName()],'post.id_nom_judet=nom_judet.id')
            ->orderBy('nume')->all(),'id','nume'),
    ]);?>

    <?php  echo $form->field($model, 'oras')->widget(DepDrop::className(),[
        'options'=>['id'=>'id_localitate'],
        'type'=>DepDrop::TYPE_SELECT2,
        'pluginOptions'=>[
            'depends'=>['id_judet'],
            'placeholder'=>'Tot Judetul',
            'url'=>Url::to(['/anunt/get-localitate'])
        ]
    ]);?>


    <div class="form-group">
        <?= Html::submitButton('Cauta', ['class' => 'btn btn-primary']) ?>
        <?php //echoHtml::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
