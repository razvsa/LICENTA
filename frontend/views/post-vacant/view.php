<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */
/** @var yii\widgets\ActiveForm $form */
$this->title = $model->denumire;
\yii\web\YiiAsset::register($this);
?>
<div class="post-vacant-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <!-- Portfolio Item Row -->
    <div class="row">

        <div class="col-md-5">
            <?php
            $tip_functie=\common\models\NomTipIncadrare::find()->where(['id'=>$model->id_nom_tip_functie])->asArray()->all();
//            echo '<pre>';
//            print_r($tip_functie);
//            echo '</pre>';
//            die();
            $localitate=\common\models\NomLocalitate::find()->where(['id'=>$model->oras])->all();
            $judet=\common\models\NomJudet::find()->where(['id'=>$model->id_nom_judet])->all();
            $nivel_studii=\common\models\NomNivelStudii::find()->where(['id'=>$model->id_nom_nivel_studii])->all();
            $nivel_cariera=\common\models\NomNivelCariera::find()->where(['id'=>$model->id_nom_nivel_cariera])->all();
            ?>

            <p style="font-size:17px"><b>Tip functie: </b> <?=$tip_functie[0]['nume']?></p>
            <p style="font-size:17px"><b>Denumire: </b> <?=$model->denumire?></p>
            <p style="font-size:17px"><b>Cerinte: </b> <?=$model->cerinte?></p>
            <p style="font-size:17px"><b>Localitate: </b> <?=$localitate[0]['nume']?></p>
            <p style="font-size:17px"><b>Judet:</b> <?= $judet[0]['nume']?></p>
            <p style="font-size:17px"><b>Nivel studii: </b> <?=$nivel_studii[0]['nume']?></p>
            <p style="font-size:17px"><b>Nivel cariera: </b> <?=$nivel_cariera[0]['nume']?></p>
        </div>

    </div>

    <?php
    if (Yii::$app->user->isGuest) {
        echo "<p>Trebuie sa fii autentificat pentru a aplica pentru acest post</p>";
        echo Html::a("Conecteaza-te",['site/login'],['class'=>'btn btn-primary']);
    } else {
        echo Html::a("Aplica pentru acest post",['/documente-user/create','id_post'=>$model->id],['class'=>'btn btn-outline-primary']);
    }
    ?>

</div>
