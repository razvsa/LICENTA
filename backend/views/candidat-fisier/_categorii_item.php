<?php
/** @var \common\models\NomTipFisierDosar $model */
/** @var \backend\controllers\CandidatFisierController $id_user */
/** @var \backend\controllers\CandidatFisierController $stare */

?>


    <div >

        <div >
            <?=\yii\helpers\Html::a(ucfirst($model->nume),['/candidat-fisier/view','id_fisier'=>$model->id, 'id_user'=>$id_user,'stare'=>$stare],['class'=>'btn btn-info','data' => ['method' => 'post']])?>
            <br>
            <br>

        </div>

    </div>

