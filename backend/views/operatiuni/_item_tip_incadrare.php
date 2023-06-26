<?php
/**@var $model \common\models\NomDepartament */

?>

<div class="card bg-color"  >
    <div class="p">
        <div class="card-body">
            <h5 class="alert alert-info" role="alert"><b>Nume: </b><?php echo $model['nume']?></h5>
            <ul class="d-flex justify-content-between">
                <li><?=\yii\helpers\Html::a('Editează',['/operatiuni/actualizeaza-tip-incadrare','id'=>$model->id],['class'=>'btn btn-outline-info',])?></li>
                <li><?=\yii\helpers\Html::a('Șterge',['/operatiuni/delete-tip-incadrare','id'=>$model->id],['class'=>'btn btn-outline-danger','data' => [
                        'confirm' => 'Sunteți sigur că doriți să ștergeți acest element?',
                        'method' => 'post',
                    ],])?></li>
            </ul>
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
