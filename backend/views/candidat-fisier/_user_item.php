<?php
/** @var \common\models\User $model */
/** @var \backend\controllers\CandidatFisierController $stare */




?>
<div class="card bg-color">

    <div class="row">

        <div class="col-sm-2 p">
            <a href="<?= \yii\helpers\Url::to(['/candidat-fisier/categorii','id_user'=>$model->id,'stare'=>$stare])?>">
            <img class="card-img" src="http://studio.ejobs.mai.gov.ro/storage/icon-document.jpg">
            </a>
        </div>
        <div class="card-body col-sm-6">
            <h5 class="card-title">
                <b>Username:</b>
                <?=$model->username?>
            </h5>
            <h5 class="card-title">
                <b>Email:</b>
                <?=$model->email?>
            </h5>
            <?=\yii\helpers\Html::a('Vezi documente',['/candidat-fisier/categorii','id_user'=>$model->id,'stare'=>$stare],['class'=>'btn btn-info','data' => ['method' => 'post']])?>

        </div>
    </div>

</div>
<br>
<br>

<style>
    .bg-color{
        background-color: #f3f8f6;
        border-radius: 35px;
    }
    .p{
        margin:15px 45px 15px 25px;
    }
</style>
