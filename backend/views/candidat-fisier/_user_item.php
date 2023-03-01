<?php
/** @var \common\models\User $model */
/** @var \backend\controllers\CandidatFisierController $stare */
?>
<div class="card">

    <div class="row">

        <div class="col-sm-3">
            <?=\yii\helpers\Html::a('Vezi documente',['/candidat-fisier/categorii','id_user'=>$model->id,'stare'=>$stare],['class'=>'btn btn-info','data' => ['method' => 'post']])?>
        </div>
        <div class="card-body col-sm-6">
            <h5 class="card-title">
                Username:
                <?=$model->username?>
            </h5>
            <h5 class="card-title">
                Email:
                <?=$model->email?>
            </h5>

        </div>
    </div>

</div>
