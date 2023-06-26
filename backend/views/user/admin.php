<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var \common\models\NomStructura $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\UserController $structura_map */
/** @var \backend\controllers\UserController $id */
?>

<br>
<h4>Selectează structura:</h4>
<?php
Dialog::widget();
DialogAsset::register($this);

$form = ActiveForm::begin();
echo  $form->field($model, 'nume')->dropDownList($structura_map,[

])->label('');
echo"<br>";
echo Html::submitButton('Confirma', ['class' => 'btn btn-success']);
ActiveForm::end();
echo"<br>";
echo Html::a('Super Administrator',['/user/super','id'=>$id],['class'=>'btn btn-success']);
echo '<br><br>';


?>

