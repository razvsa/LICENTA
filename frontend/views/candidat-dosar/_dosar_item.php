<?php
/** @var \common\models\CandidatDosar $model */
/** @var \backend\controllers\CandidatFisierController $status */




?>
    <div class="card bg-color">

        <div class="row">

            <div class="col-sm-2 p">
                <a href="<?= \yii\helpers\Url::to(['/candidat-fisier/index','id_dosar'=>$model->id,'stare'=>$status])?>">
                    <img class="card-img" src="https://studio.ejobs.mai.gov.ro/storage/icon-document.jpg">
                </a>
            </div>
            <div class="card-body col-sm-9">
                <h5 class="card-title">
                    <b>Post:</b>
                    <?=$model->getNumePost()?>
                </h5>
                <h5 class="card-title">
                    <b>Status:</b>
                    <?=$model->getStatus()?>
                </h5>
                <?=\yii\helpers\Html::a('Vezi documente dosar',['/candidat-fisier/index','id_dosar'=>$model->id],['class'=>'btn btn-info','data' => ['method' => 'post']])?>

            </div>
        </div>

    </div>
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
<?php
