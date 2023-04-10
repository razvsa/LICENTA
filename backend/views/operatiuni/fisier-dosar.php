<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomTipFisierDosar $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\OperatiuniController $fisier_dosar */
?>
<br>
<h2>Documente dosar</h2>
<br>
<h4>Insereaza un nou tip de documenet:</h4>
<?php
Dialog::widget();
DialogAsset::register($this);

$form = ActiveForm::begin();
echo  $form->field($model, 'nume')->textInput()->label('');
echo Html::submitButton('Adauga', ['class' => 'btn btn-success']);
ActiveForm::end();
echo '<br><br>';

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$fisier_dosar,
    'itemView'=>'_item_fisierdosar',
    'summary' =>'',

]);
?>

