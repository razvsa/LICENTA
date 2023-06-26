<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomNivelStudii $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\OperatiuniController $nivel_studii */
?>
<br>
<h2>Nivel Studii</h2>
<br>
<h4>Inserează un nou nivel de studii:</h4>
<?php
Dialog::widget();
DialogAsset::register($this);

$form = ActiveForm::begin();
echo  $form->field($model, 'nume')->textInput()->label('');
echo Html::submitButton('Adaugă', ['class' => 'btn btn-success']);
ActiveForm::end();
echo '<br><br>';

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$nivel_studii,
    'itemView'=>'_item_studii',
    'summary' =>'',

]);
?>

