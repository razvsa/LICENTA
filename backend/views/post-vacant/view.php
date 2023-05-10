<?php

use backend\controllers\PostVacantController;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */
/** @var PostVacantController $document */
/** @var PostVacantController $fisiere */
/** @var PostVacantController $id_post */

$this->title = $model->denumire;
\kartik\dialog\DialogAsset::register($this);
Yii::$app->params['bsDependencyEnabled'] = false;

?>
<div class="post-vacant-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>

        <?php
        $anunt=\common\models\Anunt::findOne(['id'=>$model->id_anunt]);
        if($anunt->estePostat()==0) {
            echo Html::a('Editeaza', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a('Sterge', ['sterge-post', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
                'data-method' => 'POST',
            ]);
        }
        else
            echo Html::a('Descarca lista candidati',['post-vacant/listacandidati','id_post'=>$model->id],['class'=>'btn btn-outline-info']);
        ?>
    <br><br>

    <div class="row">

        <div class="col-md-12">
            <?php
            $tip_functie=\common\models\NomTipIncadrare::find()->where(['id'=>$model->id_nom_tip_functie])->asArray()->all();
            $localitate=\common\models\NomLocalitate::find()->where(['id'=>$model->oras])->all();
            $judet=\common\models\NomJudet::find()->where(['id'=>$model->id_nom_judet])->all();
            $nivel_studii=\common\models\NomNivelStudii::find()->where(['id'=>$model->id_nom_nivel_studii])->all();
            $nivel_cariera=\common\models\NomNivelCariera::find()->where(['id'=>$model->id_nom_nivel_cariera])->all();
            ?>

            <p style="font-size:17px"><b>Denumire: </b> <?=$model->denumire?></p>
            <p style="font-size:17px"><b>Judet:</b> <?= $judet[0]['nume']?></p>
            <p style="font-size:17px"><b>Localitate: </b> <?=$localitate[0]['nume']?></p>
            <p style="font-size:17px"><b>Tip functie: </b> <?=$tip_functie[0]['nume']?></p>
            <p style="font-size:17px"><b>Nivel studii: </b> <?=$nivel_studii[0]['nume']?></p>
            <p style="font-size:17px"><b>Nivel cariera: </b> <?=$nivel_cariera[0]['nume']?></p>
            <p style="font-size:17px"><b>Data limita inscriere: </b> <?=$model->getInscriereConcurs()?></p><br>



            <h4><b>Cerinte: </b></h4><hr style='border-top: 1px solid black;'><p> <?=HtmlPurifier::process($model->cerinte)?></p><br>
            <h4><b>Tematica: </b></h4><hr  style='border-top: 1px solid black;'><p><?=HtmlPurifier::process($model->tematica)?></p><br>
            <h4><b>Bibliografie: </b></h4><hr  style='border-top: 1px solid black;'><p><?=HtmlPurifier::process($model->bibliografie)?></p><br>
        </div>
    </div>


