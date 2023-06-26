<?php

use common\models\CandidatFisier;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\controllers\CandidatFisierController $fisiere */
/** @var frontend\controllers\CandidatFisierController $id_user */
/** @var frontend\controllers\CandidatFisierController $tip_fisier */
/** @var frontend\controllers\CandidatFisierController $id_dosar */
$script = <<<JS
    $('body').on('click', '.btn-aproba', function(event) {
        var button = $(this);
        var url = button.attr('href');
        $.post(
            url,
            {},
            function(result) {
               $.pjax.reload("#validare"+button.attr('data-id'),{async:false});
               $.pjax.reload("#dosar",{async:false});
            }
        );
        return false;
    });

    $('body').on('click', '.btn-respinge', function(event) {
        var button = $(this);
        var url = button.attr('href');
        $.post(
            url,
            {},
            function(result) {
                $.pjax.reload("#validare"+button.attr('data-id'),{async:false});
                $.pjax.reload("#dosar",{async:false});
            }
        );
        return false;
    });
JS;

$this->registerJs($script,\yii\web\View::POS_READY);

?>
<div class="candidat-fisier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if(\Yii::$app->user->isGuest)
    {
        echo '<p class="alert alert-danger" role="alert">Nu aveți acces la această pagină</p>';
    }
    else{
        echo "<h1>Detalii dosar:</h1>";
        echo "<h5>Stare dosar:</h5>";

        \yii\widgets\Pjax::begin(['id'=>'dosar']);
       $dosar=\common\models\CandidatDosar::findOne(['id'=>$id_dosar]);
       if($dosar->id_status==3){
           echo "<p class='alert alert-success'>Dosar acceptat</p>";
        }
       else if($dosar->id_status==1){
           echo \yii\helpers\Html::a('Aprobă tot dosarul',['/candidat-fisier/aprobatot','id_dosar'=>$id_dosar],['class'=>'btn btn-outline-success']);
           echo "<br><br>";
           echo "<p class='alert alert-secondary'>Dosar depus (Se așteaptă validarea)</p>";
       }
       else if($dosar->id_status==2){
           echo \yii\helpers\Html::a('Aprobă tot dosarul',['/candidat-fisier/aprobatot','id_dosar'=>$id_dosar],['class'=>'btn btn-outline-success']);
           echo "<br><br>";
           echo "<p class='alert alert-danger'>Dosar respins</p>";
       }
       else{
           echo "<p class='alert alert-danger'>Dosar incomplet, nu este permisă validarea întregului dosar</p>";
       }
        \yii\widgets\Pjax::end();
        echo \yii\helpers\Html::a('Descărcați tot dosarul',['/candidat-fisier/descarcatot','id_dosar'=>$id_dosar],['class'=>'btn btn-outline-info']);
        echo "<br><br>";

        echo "<h2>Conținut dosar:</h2>";
        echo "<hr>";
        foreach($tip_fisier as $tf){

            $fisiere =  new \yii\data\ActiveDataProvider([
                'query'=>CandidatFisier::find()->where(['id_candidat_dosar'=>$id_dosar,'id_nom_tip_fisier_dosar'=>$tf['id']])]);
            $fisiere_array=\yii\helpers\ArrayHelper::toArray($fisiere->getModels());
            $nume=$tf['nume'];
            echo '<h4>'.ucfirst($nume).'</h4>';
            echo '<br>';
            echo \yii\helpers\Html::a("Descarcă", ['/candidat-fisier/descarcapartial','tip_fisier'=>$nume,'id_dosar'=>$id_dosar], ['class' => 'btn btn-outline-info']) ;
            echo "<br><br>";
           \yii\widgets\Pjax::begin(['id'=>'validare'.$tf['id']]);
            if($fisiere_array[0]['stare']==2) {

                echo Html::a('Aprobă', ['/candidat-fisier/aproba', 'tip_fisier' => $nume, 'id_dosar' => $id_dosar], ['class' => 'btn btn-success btn-aproba', 'data' => ['method' => 'post', 'id' => $tf['id']]]);
                echo "   ";
                echo Html::a('Respinge', ['/candidat-fisier/respinge', 'tip_fisier' => $nume, 'id_dosar' => $id_dosar], ['class' => 'btn btn-danger btn-respinge', 'data' => ['method' => 'post', 'id' => $tf['id']]]);
                echo "<br>";
            }
            else if($fisiere_array[0]['stare']==1)
            {
                echo Html::a('Aprobă', ['/candidat-fisier/aproba', 'tip_fisier' => $nume, 'id_dosar' => $id_dosar], ['class' => 'btn btn-success btn-aproba', 'data' => ['method' => 'post', 'id' => $tf['id']]]);
                echo "   ";
            }
            else{
                echo Html::a('Respinge', ['/candidat-fisier/respinge', 'tip_fisier' => $nume, 'id_dosar' => $id_dosar], ['class' => 'btn btn-danger btn-respinge', 'data' => ['method' => 'post', 'id' => $tf['id']]]);
                echo "<br>";
            }


            echo '<br>';

            echo \yii\widgets\ListView::widget([
                'dataProvider' => $fisiere,
                'itemView' => '_candidat_item',
                'summary' => ''
            ]);

            echo '<hr>';
            \yii\widgets\Pjax::end();
        }


    }
    ?>



</div>