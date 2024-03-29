<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomDepartament $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\OperatiuniController $departament */
?>
<br>
<h2>Structură</h2>
<br>
<h4>Inserează o noua Structură:</h4>
<?php
Dialog::widget();
DialogAsset::register($this);

$form = ActiveForm::begin();
echo  $form->field($model, 'nume')->textInput()->label('');
echo Html::submitButton('Adaugă', ['class' => 'btn btn-success']);
ActiveForm::end();
echo '<br><br>';

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$departament,
    'itemView'=>'_item_departament',
    'summary' =>'',

]);
?>

