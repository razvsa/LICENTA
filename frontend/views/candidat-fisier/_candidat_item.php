<?php
/** @var common\models\CandidatFisier $model */
?>
<div class="card-footer">

    <div class="row">

        <div class="col-md-7">

            <?php
            $src="http://ejobs.mai.gov.ro/storage/user_".$model->id_user_adaugare."/".$model->nume_fisier_adaugare;
            ?>
            <iframe width="500px" height="400px" src="<?= $src?>"></iframe>;

        </div>
        <div>
            <p>Data adaugare</p>
            <p>Nume fisier</p>
            <p>Stare</p>
            <?= \yii\helpers\Html::a("Descarca",[''],['class'=>'btn btn-primary'])?>
        </div>

    </div>

</div>
<div>
    <br>
</div>
