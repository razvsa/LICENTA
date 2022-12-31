<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\DocumenteUserController $document */
?>

<div class="documente-user-form">

    <?php $form = ActiveForm::begin(); ?>

<?php
    foreach($document as $key=>$d){
      echo $form->field($d,"[{$key}]fisiere")
    ->widget(FileInput::className(),[
                'id'=>$key,
                'bsVersion'=>'4.x',
                'options'=>[
                        'multiple'=>true,
                    'bsVersion'=>'4.x',

                ],
                'pluginOptions'=>[
                        'required'=>true,
                        'showUpload' => false,
                        'browseLabel'=>'Cauta',
                        'removeLabel'=>'Sterge',
                        'showPreview'=>false,
                        'maxFileSize'=>'3072',

                ],

        ])->label( ucfirst($d->nomTipFisierDosar->nume))->hint("Pentru incarcare multipla se selecteaza toate fisierele odata prin mentinerea tastei Ctrl");
        echo $form->field($d, "[$key]id_nom_tip_fisier_dosar")->hiddenInput(['value' => $d->id_nom_tip_fisier_dosar])->label(false);
    }

?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>
