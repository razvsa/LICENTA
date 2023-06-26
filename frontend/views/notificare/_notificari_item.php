<?php
/** @var \common\models\Notificare $model */

if($model->stare_notificare==2){//necitita
    if($model->tip==1){//valid
        $culoare="#02a113";
    }
    else if($model->tip==2)//respins
        $culoare="#d00015";
    else if($model->tip==3)//neutru
        $culoare="#0298d9";
}
else if($model->stare_notificare==1){//citita
    if($model->tip==1){//Valid
        $culoare="#95d79c";
    }
    else if($model->tip==2)//respins
        $culoare="#c4606c";
    else if($model->tip==3)//neutru
        $culoare="#5bb4dc";
}

?>

<div class="row2" style="background-color: <?= $culoare ?>; border-radius: 12px;">
    <div class="col-8 margin "><?=$model->continut?></div>
    <div class="col-1"> <?=$model->getStareNotificare()?></div>
    <div class="col-2"> <?=$model->data_adaugare?></div>
</div>

<style>
    .row2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        /*border-radius: 25px;*/
        border: 1px solid #ccc;
        padding: 8px;
        margin-bottom: 7px;
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