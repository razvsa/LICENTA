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
        <h4>Selecteaza documentele pe care doresti sa le incarci:</h4>

        <?php
        if($nr_existente!=0)
            echo " <br><h4>Documente deja existente( Pe care le actualizezi )</h4><br>";

        $form = ActiveForm::begin(); ?>

        <?php

        for($i=0;$i<$nr_existente;$i++) {
            echo $form->field($documente[$i], "[{$i}]nume")->checkbox([], false)->label($documente[$i]['nume']);
            echo $form->field($documente[$i], "[$i]id")->hiddenInput(['value' => $documente[$i]['id']])->label(false);
        }
        if(count($documente)>$nr_existente)
            echo '<br><h4>Documente inexistente( Pe care le incarci pentru prima data )</h4>';

        echo "<br>";
        for($i=$nr_existente;$i<count($documente);$i++) {
            echo $form->field($documente[$i], "[{$i}]nume")->checkbox([], false)->label($documente[$i]['nume']);
            echo $form->field($documente[$i], "[$i]id")->hiddenInput(['value' => $documente[$i]['id']])->label(false);

        }

        ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Confirma'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>