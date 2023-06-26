<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\DocumenteUserController $documente */
/** @var \frontend\controllers\DocumenteUserController $nr_existente */
?>

    <div class="documente-user-form">
        <h4>Selectează documentele pe care dorești să le încarci:</h4>

        <?php
        $form = ActiveForm::begin(); ?>

        <?php

        foreach($documente as $i=>$d) {
            echo $form->field($d, "{$i}nume")->checkbox([], false)->label($documente[$i]['nume']);
            echo $form->field($d, "{$i}id")->hiddenInput(['value' => $documente[$i]['id']])->label(false);
        }
        ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Confirma'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>