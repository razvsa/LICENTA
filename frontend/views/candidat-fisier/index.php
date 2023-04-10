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


?>
<div class="candidat-fisier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if(\Yii::$app->user->isGuest)
    {
        echo '<p class="alert alert-danger" role="alert">Nu aveti acces la aceasta pagina</p>';
    }
    else{

        $verificare=CandidatFisier::find()->where(['id_user_adaugare'=>$id_user])->asArray()->all();
        if(empty($verificare)) {
            echo "Nu aveti documente inregistrate<br><br>";
            echo Html::a('Inregistreaza documente', ['/documente-user/inregistreazadoc'], ['class' => 'btn btn-outline-info']);
        }
        else {
            echo "<h2>Lista cu documentele:</h2>";
            echo "<br>";
            echo \yii\helpers\Html::a('Descarcati toate documentele',['/candidat-fisier/descarcatot','id_user'=>$id_user],['class'=>'btn btn-outline-success']);
            echo "<br><br>";
            echo "<h5>Pentru actualizarea mai multor documente sau adaugarea de documente noi apasa aici:</h5>";

            echo \yii\helpers\Html::a('Acutualizeaza sau adauga',['/documente-user/actualizeazatot'],['class'=>'btn btn-outline-info']);
            echo "<br>";
            echo "<br>";
            foreach($tip_fisier as $tf){
                $nume=$tf['nume'];
                echo '<h4>'.ucfirst($nume).'</h4>';
                echo '<br>';
                echo \yii\helpers\Html::a("Descarca", ['/candidat-fisier/descarcapartial','tip_fisier'=>$tf['id'],'nume'=>$tf['nume']], ['class' => 'btn btn-success']) ;
                echo "\t";
                echo \yii\helpers\Html::a("Actualizeaza", ['/documente-user/actualizeazadoc','tip_fisier'=>$tf], ['class' => 'btn btn-info']) ;
                echo "\t";
                echo \yii\helpers\Html::a("Sterge", ['/candidat-fisier/stergedoc','tip_fisier'=>$tf['id']], ['class' => 'btn btn-danger']) ;
                echo '<br>';
                $fisiere =  new \yii\data\ActiveDataProvider([
                    'query'=>CandidatFisier::find()->where(['id_user_adaugare'=>Yii::$app->user->identity->id,'id_nom_tip_fisier_dosar'=>$tf['id']])]);
                echo '<br>';
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $fisiere,
                    'itemView' => '_candidat_item',
                    'summary' => ''
                ]);
                echo '<hr>';
            }

        }
    }
    ?>



</div>