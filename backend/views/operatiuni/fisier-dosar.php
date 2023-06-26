<?php

use common\models\NomStructura;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomTipFisierDosar $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\OperatiuniController $fisier_dosar */
/** @var \backend\controllers\OperatiuniController $structura_finala */
?>
<br>
<h2>Documente dosar</h2>
<br>
<h4>Inserează un nou tip de document:</h4>
<?php
Dialog::widget();
DialogAsset::register($this);
$form = ActiveForm::begin();
echo  $form->field($model, 'nume')->textInput()->label('');
if(\Yii::$app->user->getIdentity()->admin==0)
    echo  $form->field($model, 'id_structura')->dropDownList($structura_finala,[
            'prompt'=>'Alege o structură'
    ])->label('Structură');
echo Html::submitButton('Adaugă', ['class' => 'btn btn-success']);
ActiveForm::end();
echo '<br><br>';

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$fisier_dosar,
    'itemView'=>'_item_fisierdosar',
    'summary' =>'',

]);
?>

