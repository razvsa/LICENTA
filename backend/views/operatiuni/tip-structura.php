<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomStructura $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\OperatiuniController $tip_structura */
?>
<br>
<h2>Structură</h2>
<br>
<h4>Inserează o nouă structură:</h4>
<br>
<?php
Dialog::widget();
DialogAsset::register($this);
$structura=\common\models\NomStructura::find()->all();
$structura_map=\yii\helpers\ArrayHelper::map($structura,'id','nume');
$structura_finala=[];
$structura_finala[0]='---';
$structura_finala=array_merge($structura_finala,$structura_map);

$form = ActiveForm::begin();
echo  $form->field($model, 'nume')->textInput()->label('Denumire Structură');
echo  $form->field($model, 'abreviere')->textInput()->label('Abreviere');
echo  $form->field($model, 'adresa')->textInput()->label('Adresă');
echo  $form->field($model, 'nr_telefon')->textInput()->label('Număr de telefon');
echo  $form->field($model, 'email')->textInput()->label('Email');
echo  $form->field($model, 'apartine_de')->dropDownList($structura_finala,[
        'prompt'=>''
])->label('Denumire Structură');
echo Html::submitButton('Adaugă', ['class' => 'btn btn-success']);
echo "\t";
$model=new \common\models\NomStructura();
//echo Html::a('Resteaza',['/operatiuni/tip-structura',],['class'=>'btn btn-outline-secondary']);
ActiveForm::end();
echo '<br><br>';

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$tip_structura,
    'itemView'=>'_item_structura',
    'summary' =>'',

]);
?>

