<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\PostVacantController $id_anunt */
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
    $id_anunt_post_curent=\common\models\KeyAnuntPostVacant::find()->where(['id_post_vacant'=>$model->id])->asArray()->all();
    $verificare=\common\models\KeyInscrierePostUser::find()->where(['id_user'=>Yii::$app->user->identity->id,'id_post'=>$model->id])->asArray()->all();
    if (Yii::$app->user->isGuest) {
        echo "<p>Trebuie sa fii autentificat pentru a aplica pentru acest post</p>";
        echo Html::a("Conecteaza-te",['site/login'],['class'=>'btn btn-primary']);
    }
    else {
        $gasit=0;
        if(empty($verificare)) {
            $anunturi=\common\models\KeyInscrierePostUser::find()
               ->innerJoin(['kap'=>\common\models\KeyAnuntPostVacant::tableName()],'kap.id_post_vacant=key_inscriere_post_user.id_post')
               ->where(['key_inscriere_post_user.id_user'=>Yii::$app->user->identity->id])->select(['kap.id_anunt'])->asArray()->all();
           for($i=0;$i<count($anunturi);$i++)
           {
               if($anunturi[$i]['id_anunt']==$id_anunt_post_curent[0]['id_anunt'])
                   $gasit=1;
           }
            if($gasit==1){
                echo '<p class="bg-warning">Ai aplicat deja pentru un post din anuntul curent</p>';
            }
            else
                echo Html::a("Aplica pentru acest post",['/documente-user/create','id_post'=>$model->id],['class'=>'btn btn-outline-primary']);
        }
       else{
           echo '<p class="bg-success">Ai aplicat deja pentru acest post</p>';
       }
    }
?>

</div>
