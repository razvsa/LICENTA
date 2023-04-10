<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomTipIncadrare $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\OperatiuniController $tip_incadrare */
?>
<br>
<h2>Tip Incadrare</h2>
<br>
<h4>Insereaza un nou tip de incadrare:</h4>
<?php
Dialog::widget();
DialogAsset::register($this);

$form = ActiveForm::begin();
echo  $form->field($model, 'nume')->textInput()->label('');
echo Html::submitButton('Adauga', ['class' => 'btn btn-success']);
ActiveForm::end();
echo '<br><br>';

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$tip_incadrare,
    'itemView'=>'_item_tip_incadrare',
    'summary' =>'',

]);
?>

