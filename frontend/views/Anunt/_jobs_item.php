<?php
/**@var $model \common\models\Anunt */
?>
<div class="card-body card bg-color mrg" style="border-radius: 10px;"y">
    <div class="row"  >
        <div class="col-lg-1">

        </div>
        <div class="col-md-9 col-lg-10 col-xl-8">
            <a href="<?= \yii\helpers\Url::to(['/anunt/view','id'=>$model->id])?>">
            <h3><?=$model->titlu?></h3>
                <hr style='border-top: 1px solid black;'>
            </a>
            <div class="mt-1 mb-0">
                <span > • </span>
                <span class="alert-info custom-text"><b>Dată depunere dosar: </b><?php echo $model->data_depunere_dosar?></span><br><br>
                <span > • </span>
                <span class="alert-info custom-text"><b>Dată limită înscriere: </b><?php echo $model->data_limita_inscriere_concurs?><br /></span><br>
                <span> • </span>
                <span class="alert-info custom-text"><b>Dată concurs: </b><?php echo $model->data_concurs?></span><br>
            </div>
            <p class="text-truncate mb-4 mb-md-0">
            <hr style='border-top: 1px solid black;'>
            <h4><?php echo $model->getNumeStructura()?></h4>
            </p>
        </div>
        <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
            <div class="d-flex flex-row align-items-center mb-1">
                <h5 class="mb-1 me-1">Număr posturi: <?= $model->getNumarPosturi()?></h5>
            </div>
            <?php
                if($model->getValabilitate()==0)
                    echo "<h6 class='text-danger'>Anunț expirat</h6>";
                else
                    echo "<h6 class='text-success'>Anunț valabil</h6>";

            ?>

            <div class="d-flex flex-column mt-4">
                <?=\yii\helpers\Html::a('Vezi posturi',['/anunt/view','id'=>$model->id],['class'=>'btn btn-outline-info'])?>
            </div>
        </div>
    </div>
</div>
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
    .mrg{
        margin-right: auto;
    }
    .card-header{height: 60px;}
    .bg-color{
        background-color: #f3f8f6;
        border-radius: 30px;
    }
    .custom-text {
        font-size: 17px;
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


