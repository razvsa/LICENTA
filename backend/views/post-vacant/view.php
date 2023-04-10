<?php

use backend\controllers\PostVacantController;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use common\models\KeyAnuntPostVacant;

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
    <p>
        <?= Html::a('Editeaza', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Sterge', ['sterge-post', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
            'data-method' => 'POST',
        ]) ?>
    </p>

    <div class="row">

        <div class="col-md-5">
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
            <p style="font-size:17px"><b>Data limita inscriere: </b> <?=$model->getInscriereConcurs()?></p>
            <p style="font-size:17px"><b>Cerinte: </b> <?=$model->cerinte?></p>
            <p style="font-size:17px"><b>Tematica: </b> <?=$model->tematica?></p>
            <p style="font-size:17px"><b>Bibliografie: </b> <?=$model->bibliografie?></p>
        </div>
    </div>
    <?php
        $info=KeyAnuntPostVacant::find()->where(['id_post_vacant'=>$model->id])->select(['id_anunt'])->asArray()->all();
    ?>

    <?= Html::a('Descarca lista candidati',['post-vacant/listacandidati','id_post'=>$model->id],['class'=>'btn btn-outline-info'])?>
    <br>
    <br>
    <h3>Incarca document nou:</h3>
    <?php
$form = \yii\widgets\ActiveForm::begin(); ?>

<?php
    Yii::$app->params['bsDependencyEnabled'] = false;
foreach($document as $key=>$d){
    echo $form->field($d,"[{$key}]fisiere")
        ->widget(\kartik\file\FileInput::className(),[
            'id'=>$key,
            'options'=>[
                'multiple'=>true,


            ],
            'pluginOptions'=>[
                'required'=>true,
                'showUpload' => false,
                'browseLabel'=>'Cauta',
                'removeLabel'=>'Sterge',
                'showPreview'=>false,
                'maxFileSize'=>'3072',

            ],

        ])->label('')->hint("Pentru incarcare multipla se selecteaza toate fisierele odata prin mentinerea tastei Ctrl");
    //echo $form->field($d, "[$key]id_nom_tip_fisier_dosar")->hiddenInput(['value' => $d->id_nom_tip_fisier_dosar])->label(false);
}

?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Confirma'), ['class' => 'btn btn-success']) ?>
    </div>

</div>
    <?php ActiveForm::end(); ?>

    <br>
    <br>
    <h4>Fisierele postului:</h4>
    <br>
<?php

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$fisiere,
    'itemView'=>'_fisier_item',
    'viewParams'=>['id_post'=>$id_post],
    'summary' =>''
]);
