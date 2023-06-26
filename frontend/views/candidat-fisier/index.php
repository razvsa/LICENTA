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


?>
<div class="candidat-fisier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if(\Yii::$app->user->isGuest)
    {
        echo '<p class="alert alert-danger" role="alert">Nu aveți acces la această pagină</p>';
    }
    else{

        $verificare=CandidatFisier::find()->where(['id_user_adaugare'=>$id_user])->asArray()->all();
        if(empty($verificare)) {
            echo "Nu aveți documente înregistrate<br><br>";
            echo Html::a('Înregistrează documente', ['/documente-user/inregistreazadoc'], ['class' => 'btn btn-outline-info']);
        }
        else {
            echo "<h2>Conținut dosar:</h2><hr style='border-top: 1px solid black;'>";
            echo "<br>";
            $dosar=\common\models\CandidatDosar::findOne(['id'=>$id_dosar]);
            if($dosar->id_status==3){
                echo "<p class='alert alert-success'>Dosar acceptat</p>";
            }
            else if($dosar->id_status==1){
                echo \yii\helpers\Html::a('Șterge dosarul',['/candidat-dosar/stergedosar','id_dosar'=>$id_dosar],['class'=>'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],]);
                echo "<br><br>";
                echo "<p class='alert alert-secondary'>Dosar depus (Se așteaptă validarea)</p>";
            }
            else if($dosar->id_status==2){
                echo \yii\helpers\Html::a('Șterge dosarul',['/candidat-dosar/stergedosar','id_dosar'=>$id_dosar],['class'=>'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],]);
                echo "<br><br>";
                echo "<p class='alert alert-danger'>Dosar respins</p>";
            }
            else{
                $doc_lipsa=$dosar->getListaDocumenteLipsa();
                echo "<p class='alert alert-danger'>Dosar incomplet: $doc_lipsa</p>";

                echo \yii\helpers\Html::a('Șterge dosarul',['/candidat-dosar/stergedosar','id_dosar'=>$id_dosar],['class'=>'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],]);
                echo "\t";
                echo Html::a('Adaugă Restul Documentelor',['/candidat-dosar/completeazadosar','id_dosar'=>$id_dosar],['class'=>'btn btn-outline-success']);
                echo "\t";
            }
            echo \yii\helpers\Html::a('Descărcați toate documentele',['/candidat-fisier/descarcatot','id_user'=>$id_user,'id_dosar'=>$id_dosar],['class'=>'btn btn-outline-success']);
//            echo "<br><br>";
//            echo "<h5>Pentru actualizarea mai multor documente sau adaugarea de documente noi apasa aici:</h5>";
//
//            echo \yii\helpers\Html::a('Acutualizeaza sau adauga',['/documente-user/actualizeazatot','id_dosar'=>$id_dosar],['class'=>'btn btn-outline-info']);
            echo "<br>";
            echo "<br>";
            foreach($tip_fisier as $tf){
                $nume=$tf['nume'];
                echo '<h4>'.ucfirst($nume).'</h4><hr style="border-top: 1px solid black;">';

                echo \yii\helpers\Html::a("Descarcă", ['/candidat-fisier/descarcapartial','tip_fisier'=>$tf['id'],'nume'=>$tf['nume'],'id_dosar'=>$id_dosar], ['class' => 'btn btn-success']) ;
                echo "\t";
                if($dosar->id_status!=3) {
                    echo \yii\helpers\Html::a("Actualizează", ['/documente-user/actualizeazadoc', 'id_dosar' => $id_dosar, 'tip_fisier' => $tf], ['class' => 'btn btn-info']);
                    echo "\t";
                    echo \yii\helpers\Html::a("Șterge", ['/candidat-fisier/stergedoc', 'tip_fisier' => $tf['id'], 'id_dosar' => $id_dosar], ['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],]);
                }
                echo '<br>';
                $fisiere =  new \yii\data\ActiveDataProvider([
                    'query'=>CandidatFisier::find()->where(['id_user_adaugare'=>Yii::$app->user->identity->id,'id_candidat_dosar'=>$id_dosar,'id_nom_tip_fisier_dosar'=>$tf['id']])]);
                echo '<br>';
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $fisiere,
                    'itemView' => '_candidat_item',
                    'summary' => ''
                ]);
                echo '<br>';
            }

        }
    }
    ?>



</div>