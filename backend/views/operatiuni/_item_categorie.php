<?php
/**@var $model \common\models\NomTipCategorie */

?>

<div class="card bg-color"  >
    <div class="p">
        <div class="card-body">
            <h5 class="alert alert-info" role="alert"><b>Nume: </b><?php echo $model['nume']?></h5>
            <ul class="d-flex justify-content-between">
                <li><?php if(Yii::$app->user->getIdentity()->admin==0)
                    echo \yii\helpers\Html::a('Editeaza',['/operatiuni/actualizeaza-categorie','id'=>$model->id],['class'=>'btn btn-outline-info',])?></li>
                <li><?php if(Yii::$app->user->getIdentity()->admin==0)
                    echo \yii\helpers\Html::a('Sterge',['/operatiuni/delete-categorie','id'=>$model->id],['class'=>'btn btn-outline-danger','data' => [
                        'confirm' => 'Sunteți sigur că doriți să ștergeți acest element?',
                        'method' => 'post',
                    ],])?></li>
                <li><?=\yii\helpers\Html::a('Editeaza lista fisiere necesare',['/operatiuni/fisiere-necesare','id_categorie'=>$model->id],['class'=>'btn btn-outline-primary'])?></li>
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
