<?php
/**@var $model \common\models\NomStructura */

?>

<div class="card bg-color"  >
    <div class="p">

        <div class="col">

            <div class="card-header bg-transparent">
                <ul id="ul" class="d-flex justify-content-between">
                    <li ><h4><?=$model->nume?></h4></li></a>
                    <li ><h5><?=$model->abreviere?></h5></li>
                </ul>
            </div>
            <div class="card-body">
                <ul class="d-flex justify-content-between">
                    <li><h5 ><b>Adresa: </b><?php echo $model->adresa?></h5></li>
                </ul>
                <ul class="d-flex justify-content-between">
                    <li><h6 class="alert alert-info" role="alert"><b>Numar telefon: </b><?php echo $model->nr_telefon?></h6></li>
                    <li><h6 class="alert alert-info" role="alert"><b>Email: </b><?php echo $model->email?></h6></li>
                </ul>
                <ul class="d-flex justify-content-between">
                    <li><?=\yii\helpers\Html::a('Editeaza',['/operatiuni/actualizeaza-tip-structura','id'=>$model->id],['class'=>'btn btn-outline-info'])?></li>
                    <li><?=\yii\helpers\Html::a('Sterge',['/operatiuni/delete-tip-structura','id'=>$model->id],['class'=>'btn btn-outline-danger','data' => [
                            'confirm' => 'Sunteți sigur că doriți să ștergeți acest element?',
                            'method' => 'post',]])?></li>
                </ul>

            </div>
            <?php
            if($model->apartine_de!=0){
                echo '<div class="card-footer bg-transparent"><ul class="d-flex justify-content-between"><li><p ><b>Apartine de: </b>';

                echo $model->getApartine();
                echo '</p></li></ul></div>';
            }
        ?>

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
    .card-body{
        height: 200px;
    }
    .card-footer{
        height: 55px;
    }
    .p{
        margin:15px 45px 0px 20px;
    }
    .card-header{height: 45px;}
    .bg-color{
        background-color: #f3f8f6;
        border-radius: 35px;
    }
</style>
