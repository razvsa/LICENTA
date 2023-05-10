<?php
/**@var $model \common\models\NomTipFisierDosar */

?>

<div class="card bg-color"  >
    <div class="p">
        <div class="card-body">
            <h5 class="alert alert-info" role="alert"><b>Nume: </b><?php echo $model['nume']?></h5>
            <ul class="d-flex justify-content-between">
                <li><?=\yii\helpers\Html::a('Editeaza',['/operatiuni/actualizeaza-fisier-dosar','id'=>$model->id],['class'=>'btn btn-outline-info',])?></li>
                <li><?=\yii\helpers\Html::a('Sterge',['/operatiuni/delete-fisier-dosar','id'=>$model->id],['class'=>'btn btn-outline-danger','data' => [
                        'confirm' => 'Sunteți sigur că doriți să ștergeți acest element?',
                        'method' => 'post',
                    ],])?></li>
            </ul>
            <?php
            if($model->id_structura!=0){
                echo '<div class="card-footer bg-transparent"><ul class="d-flex justify-content-between"><li><p ><b>Existent doar la structura: </b>';
                echo $model->getNumeStructura();
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

    .p {
    }
    .bg-color{
        background-color: #f3f8f6;
    }
</style>
