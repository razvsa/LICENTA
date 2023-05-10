<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;

/** @var common\models\NomTipCategorie $model */
/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var \backend\controllers\OperatiuniController $tip_categorie */
?>
    <br>
    <h2>Categorie posturi</h2>
    <br>

    <?php
    Dialog::widget();
    DialogAsset::register($this);

    if(Yii::$app->user->getIdentity()->admin==0) {
        echo "<h4>Insereaza o noua categorie:</h4>";
        $form = ActiveForm::begin();
        echo $form->field($model, 'nume')->textInput()->label('');
        echo Html::submitButton('Adauga', ['class' => 'btn btn-success']);
        ActiveForm::end();
        echo '<br><br>';
    }

    echo \yii\widgets\ListView::widget([

        'dataProvider'=>$tip_categorie,
        'itemView'=>'_item_categorie',
        'summary' =>''
    ]);
    ?>
