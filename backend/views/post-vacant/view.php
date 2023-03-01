<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\KeyAnuntPostVacant;
/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */

$this->title = $model->denumire;
\yii\web\YiiAsset::register($this);


?>
<div class="post-vacant-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
        $info=KeyAnuntPostVacant::find()->where(['id_post_vacant'=>$model->id])->select(['id_anunt'])->asArray()->all();
//        echo'<pre>';
//        print_r($info);
//        echo'</pre>';
//        die();
    ?>

    <?php echo Html::a('OK',['/anunt/index'],['class'=>'btn btn-success'])?>
    <?php echo Html::a('Vizualizeaza celelalte posturi ale anuntului',['post-vacant/index','id'=>$info[0]['id_anunt']],['class'=>'btn btn-success'])?>
    <br>
    <br>
    <?= Html::a('Descarca lista candidati',['post-vacant/listacandidati','id_post'=>$model->id],['class'=>'btn btn-outline-info'])?>

</div>
