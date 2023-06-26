<?php
/**@var $model \common\models\PostVacant */

?>

<div class="card bg-color"  >
    <div class="p">

        <div class="col">

            <div class="card-header bg-transparent">
                <ul id="ul" class="d-flex justify-content-between">
                    <a href="<?= \yii\helpers\Url::to(['/post-vacant/view','id'=>$model->id])?>">
                        <li ><h3><?=$model->denumire?></h3></li></a>
                    <li ><h5><?=$model->getLocalitate().', '.$model->getJudet()?></h5></li>
                </ul>
            </div>
            <div class="card-body">
                <ul class="d-flex justify-content-between">
                    <li><h4 ><b>Structură: </b><?php echo $model->getStructura()?></h4></li>
                </ul>
                <ul class="d-flex justify-content-between">
                    <li><h5 class="alert alert-info" role="alert"><b>Experiență: </b><?php echo $model->getCariera()?></h5></li>
                    <li><h5 class="alert alert-info" role="alert"><b>Studii: </b><?php echo $model->getStudii()?></h5></li>
                    <li><h5 class="alert alert-info" role="alert"><b>Funcție: </b><?php echo $model->getFunctie()?></h5></li>
                </ul>
                <ul class="d-flex justify-content-between">
                    <li><?php if($model->estePostat()==1) echo \yii\helpers\Html::a('Editează',['/post-vacant/update','id'=>$model->id],['class'=>'btn btn-outline-info'])?></li>
                    <li><?php if($model->estePostat()==1) echo \yii\helpers\Html::a('Șterge',['/post-vacant/sterge-post','id'=>$model->id],['class'=>'btn btn-outline-danger'])?></li>
                    <li><?=\yii\helpers\Html::a('Vezi detalii',['/post-vacant/view','id'=>$model->id],['class'=>'btn btn-outline-info'])?></li>
                </ul>

            </div>
            <div class="card-footer bg-transparent">
                <ul class="d-flex justify-content-between">
<!--                    <li><p ><b>Postat la: </b>--><?php //echo $model->data_postare?><!--</p></li>-->
                    <li><p ><b>Dată limită înscriere: </b><?php echo $model->getInscriereConcurs()?></p></li>

                </ul>
            </div>

        </div>


    </div>
</div>
<div>
    <br>
    <br>
</div>
<style>
    ul {
        list-style-type: none;
    }
    brd{
        border-radius: 25px;
    }
    .p{
        margin:15px 45px 15px 25px;
    }
    .card-header{height: 60px;}
    .bg-color{
        background-color: #f3f8f6;
        border-radius: 35px;
    }
</style>
