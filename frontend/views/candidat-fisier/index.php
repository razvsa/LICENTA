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
    $verificare=CandidatFisier::find()->where(['id_user_adaugare'=>$id_user])->asArray()->all();
        if(empty($verificare))
            echo "Nu aveti documente inregistrate";
        else {
            foreach($tip_fisier as $tf){
                $nume=$tf['nume'];
                echo '<h4>'.ucfirst($nume).'</h4>';

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

    ?>



</div>