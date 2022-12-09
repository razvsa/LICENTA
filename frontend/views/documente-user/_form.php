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
      echo $form->field($d,"[{$key}]fisiere")->textInput()->label($d->nomTipFisierDosar->nume);
//->widget(FileInput::className(),[
//
//                'id'=>$key,
//                'bsVersion'=>'4.x',
//                'options'=>[
//
//                        'multiple'=>true,
//                ],
//                'pluginOptions'=>[
//                        'required'=>false,
//                        'browseLabel'=>'Cauta',
//                        'removeLabel'=>'Sterge',
//                        'showPreview'=>false,
//                        'showUpload'=>true,
//                ]
//        ])->label($d->nomTipFisierDosar->nume)->hint("Salut hint");
    }

?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
