<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use dosamigos\ckeditor\CKEditor;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \common\models\NomNivelStudii $modelStudii */

?>


<?php
   $stud=\common\models\NomNivelStudii::find()->all();
   $stud_map=ArrayHelper::map($stud,'id','nume');
   $cariera=\common\models\NomNivelCariera::find()->all();
   $cariera_map=ArrayHelper::map($cariera,'id','nume');
   $functie=\common\models\NomTipIncadrare::find()->all();
   $functie_map=ArrayHelper::map($functie,'id','nume');
?>


<div class="post-vacant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_nom_tip_functie')->dropDownList($functie_map,[
            'placeholder'=>' '
    ])?>

    <?= $form->field($model, 'pozitie_stat_organizare')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'denumire')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cerinte')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic',
        'clientOptions' => [
            'fontSize_sizes' => '10/10px;12/12px;14/14px;16/16px;18/18px;20/20px;24/24px;28/28px;32/32px;36/36px;42/42px',
            'font_names' => 'Arial/Arial, Helvetica, sans-serif; Comic Sans MS/Comic Sans MS, cursive; Courier New/Courier New, Courier, monospace; Georgia/Georgia, serif; Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif; Tahoma/Tahoma, Geneva, sans-serif; Times New Roman/Times New Roman, Times, serif; Trebuchet MS/Trebuchet MS, Helvetica, sans-serif; Verdana/Verdana, Geneva, sans-serif',
            'toolbar' => [
                [
                    'name' => 'document',
                    'items' => ['Source', '-', 'NewPage', 'Preview', '-', 'Templates']
                ],
                [
                    'name' => 'clipboard',
                    'items' => ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                ],
                [
                    'name' => 'editing',
                    'items' => ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
                ],
                '/',
                [
                    'name' => 'basicstyles',
                    'items' => ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat']
                ],
                [
                    'name' => 'paragraph',
                    'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']
                ],
                [
                    'name' => 'links',
                    'items' => ['Link', 'Unlink', 'Anchor']
                ],
                '/',
                [
                    'name' => 'styles',
                    'items' => ['Styles', 'Format', 'Font', 'FontSize']
                ],
                [
                    'name' => 'colors',
                    'items' => ['TextColor', 'BGColor']
                ],
                [
                    'name' => 'tools',
                    'items' => ['Maximize', 'ShowBlocks']
                ],
            ],
        ],

    ]) ?>

    <?= $form->field($model, 'tematica')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'custom',
        'clientOptions' => [
            # 'extraPlugins' => 'pbckcode', *//Download already and in the plugins folder...*
            'toolbar' => [
                [
                    'name' => 'row1',
                    'items' => [
                        'Source', '-',
                        'Bold', 'Italic', 'Underline', 'Strike', '-',
                        'Subscript', 'Superscript', 'RemoveFormat', '-',
                        'TextColor', 'BGColor', '-',
                        'NumberedList', 'BulletedList', '-',
                        'Outdent', 'Indent', '-', 'Blockquote', '-',
                        'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'list', 'indent', 'blocks', 'align', 'bidi', '-',
                        'Link', 'Unlink', 'Anchor', '-',
                        'ShowBlocks', 'Maximize',
                        // 'pbckcode',
                    ],
                ],
                [
                    'name' => 'row2',
                    'items' => [
                        'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'Iframe', '-',
                        'NewPage', 'Print', 'Templates', '-',
                        'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                        'Undo', 'Redo', '-',
                        'Find', 'SelectAll', 'Format', 'Font', 'FontSize',
                        'base64image',
                    ],
                ],
            ],
        ],
    ]) ?>


    <?= $form->field($model, 'bibliografie')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic',
        'clientOptions' => [
            'fontSize_sizes' => '10/10px;12/12px;14/14px;16/16px;18/18px;20/20px;24/24px;28/28px;32/32px;36/36px;42/42px',
            'font_names' => 'Arial/Arial, Helvetica, sans-serif; Comic Sans MS/Comic Sans MS, cursive; Courier New/Courier New, Courier, monospace; Georgia/Georgia, serif; Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif; Tahoma/Tahoma, Geneva, sans-serif; Times New Roman/Times New Roman, Times, serif; Trebuchet MS/Trebuchet MS, Helvetica, sans-serif; Verdana/Verdana, Geneva, sans-serif',
            'toolbar' => [
                [
                    'name' => 'document',
                    'items' => ['Source', '-', 'NewPage', 'Preview', '-', 'Templates']
                ],
                [
                    'name' => 'clipboard',
                    'items' => ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                ],
                [
                    'name' => 'editing',
                    'items' => ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
                ],
                '/',
                [
                    'name' => 'basicstyles',
                    'items' => ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat']
                ],
                [
                    'name' => 'paragraph',
                    'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']
                ],
                [
                    'name' => 'links',
                    'items' => ['Link', 'Unlink', 'Anchor']
                ],
                '/',
                [
                    'name' => 'styles',
                    'items' => ['Styles', 'Format', 'Font', 'FontSize']
                ],
                [
                    'name' => 'colors',
                    'items' => ['TextColor', 'BGColor']
                ],
                [
                    'name' => 'tools',
                    'items' => ['Maximize', 'ShowBlocks']
                ],
            ],
        ],

    ]) ?>
<!--    --><?php //= $form->field($model, 'bibliografie')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_nom_judet')->widget(Select2::className(),[
        'options'=>[
            'id'=>'id_judet',
            'placeholder' => 'Alege Judetul'
        ],
        'bsVersion'=>'4.x',
        'data'=>\yii\helpers\ArrayHelper::map(\common\models\NomJudet::find()->orderBy('nume')->all(),'id','nume'),
    ]) ?>

    <?= $form->field($model, 'oras')->widget(DepDrop::className(),[
        'options'=>['id'=>'id_localitate'],
        'type'=>DepDrop::TYPE_SELECT2,
        'pluginOptions'=>[
            'depends'=>['id_judet'],
            'placeholder'=>'',
            'url'=>Url::to(['/anunt/get-localitate'])
        ]
    ]) ?>

    <?= $form->field($model, 'id_nom_nivel_studii')->dropDownList($stud_map)?>

    <?= $form->field($model, 'id_nom_nivel_cariera')->dropDownList($cariera_map) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
