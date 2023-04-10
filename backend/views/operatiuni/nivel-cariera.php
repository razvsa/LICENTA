<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomNivelCariera $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\OperatiuniController $nivel_cariera */?>
<br>
<h2>Nivel cariera</h2>
<br>
<h4>Insereaza un nou nivel de cariera:</h4>
<?php
    Dialog::widget();
    DialogAsset::register($this);

    $form = ActiveForm::begin();
    echo  $form->field($model, 'nume')->textInput()->label('');
    echo Html::submitButton('Adauga', ['class' => 'btn btn-success']);
    ActiveForm::end();
    echo '<br><br>';

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$nivel_cariera,
    'itemView'=>'_item_cariera',
    'summary' =>''
]);
    ?>
