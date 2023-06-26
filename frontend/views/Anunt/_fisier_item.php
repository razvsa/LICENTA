<?php
/** @var \common\models\AnuntFisier $model */


?>
<div class="row2">
    <div class="col-4 margin "><b><?=$model->nume_fisier_afisare?></b></div>
    <div class="col-5"><b>Postat la :</b> <?=$model->data_adaugare?></div>
    <div class="col-2"><?=\yii\helpers\Html::a('Descarcă',['/anunt/descarca','id'=>$model->id],['class'=>'btn btn-info'])?></div>
</div>
<style>
    .row2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #e4e7e5;
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }
    .margin{
        margin-left: 20px;
    }
    .col-3 {
        flex-basis: 25%;
        text-align: left;
        font-size: 18px;
        color: #333;
    }
</style>