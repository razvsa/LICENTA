<?php
/**@var $model \common\models\Anunt */
?>
<div class="card bg-color">
    <div class="p">
        <div class="col">
            <div class="card-header bg-transparent">
                <ul id="ul" class="d-flex flex-wrap justify-content-between">
                    <a href="<?= \yii\helpers\Url::to(['/post-vacant/index','id'=>$model->id])?>">
                        <li><h3><b>Departament: </b><?=$model->departament?></h3></li>
                    </a>
                </ul>
            </div>
            <div class="card-body">
                <ul class="d-flex flex-wrap justify-content-between">
                    <li><h5 class="alert alert-info" role="alert"><b>Data depunere dosar: </b><?php echo $model->data_depunere_dosar?></h5></li>
                    <li><h5 class="alert alert-info" role="alert"><b>Data limita inscriere: </b><?php echo $model->data_limita_inscriere_concurs?></h5></li>
                    <li><h5 class="alert alert-info" role="alert"><b>Data concurs: </b><?php echo $model->data_concurs?></h5></li>
                    <li><?=\yii\helpers\Html::a('Vezi posturi',['/post-vacant/index','id'=>$model->id],['class'=>'btn btn-outline-info'])?></li>
                </ul>
            </div>
            <div class="card-footer bg-transparent">
                <ul class="d-flex flex-wrap justify-content-between">
                    <li><p><b>Postat la: </b><?php echo $model->data_postare?></p></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<style>
    ul {
        list-style-type: none;
    }
    brd{
        border-radius: 25px;
    }
    .p{
        margin:1% 1% 1% 1%;
    }
    .card-header{height: 60px;}
    .bg-color{
        background-color: #f3f8f6;
        border-radius: 30px;
    }

    /* Stiluri pentru telefoane */
    @media only screen and (max-width: 767px) {
        .p {
            margin: 0;
        }
        .card-header {
            height: auto;
            padding-top: 10px;
        }
        .card-body {
            padding: 10px;
        }
        .alert-info {
            font-size: 12px;
        }
        .btn {
            font-size: 17px;
        }
    }
</style>


