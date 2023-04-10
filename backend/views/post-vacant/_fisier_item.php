<?php
/** @var \common\models\PostFisier $model */
/** @var \backend\controllers\PostVacantController $id_post */
?>
<div class="row2">
    <div class="col-5 margin "><b><?=$model->nume_fisier?></b></div>
    <div class="col-4"><b>Postat la :</b> <?=$model->data_adaugare?></div>
    <div class="col-1"><?=\yii\helpers\Html::a('Descarca',['/post-vacant/descarca','id'=>$model->id],['class'=>'btn btn-info'])?></div>
    <div class="col-1 margin-right"><?=\yii\helpers\Html::a('Sterge',['/post-vacant/stergefisier','id'=>$model->id,'id_post'=>$id_post],['class'=>'btn btn-danger','data' => [
            'confirm' => 'Sunteți sigur că doriți să ștergeți acest element?',
            'method' => 'post',
        ]])?></div>
</div>
<style>
    .row2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #cde6ea;
        border-radius: 25px;
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }
    .margin{
        margin-left: 20px;
    }
    .margin-right{
        margin-right: 30px;
    }

    .col-3 {
        flex-basis: 25%;
        text-align: left;
        font-size: 18px;
        color: #333;
    }
</style>