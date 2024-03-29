<?php
/** @var \common\models\PostVacant $model */
/** @var \backend\controllers\CandidatFisierController $status */

    $dosare=\common\models\CandidatDosar::find()
            ->where(['id_post_vacant'=>$model->id,'id_status'=>$status])
            ->asArray()->all();
    $dosare_all=\common\models\CandidatDosar::find()
        ->where(['id_post_vacant'=>$model->id])
        ->asArray()->all();
    if($status==1)
        $string="Număr dosare în așteptare: ";
    else if($status==3)
        $string="Număr dosare aprobate: ";
    else if($status==4)
        $string="Număr dosare incomplete: ";
    else if($status==2)
        $string="Număr dosare respinse: ";
?>
<div class="card bg-color">

    <div class="row">

        <div class="col-sm-2 p">
            <a href="<?= \yii\helpers\Url::to(['/candidat-fisier/dosare','id_post'=>$model->id,'status'=>$status])?>">
                <img class="card-img" src="https://studio.ejobs.mai.gov.ro/storage/icon-document.jpg">
            </a>
        </div>
        <div class="card-body col-sm-6">
            <h4 class="card-title">
                <b>Denumire post:</b>
                <?=$model->denumire?>
            </h4>
            <h5 class="card-title">
                <b><?=$string?></b>
                <?=count($dosare)?>
            </h5>
            <h5 class="card-title">
                <b>Număr total dosare:</b>
                <?=count($dosare_all)?>
            </h5>
            <?=\yii\helpers\Html::a('Vezi dosarele postului',['/candidat-fisier/dosare','id_post'=>$model->id,'status'=>$status],['class'=>'btn btn-outline-info','data' => ['method' => 'post']])?>

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
