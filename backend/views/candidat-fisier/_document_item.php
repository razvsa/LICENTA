<?php
/** @var common\models\CandidatFisier $model */
?>
<div class="card-footer">

    <div class="row">

        <div class="col-md-7">

            <?php
            $src="http://ejobs.mai.gov.ro/storage/user_".$model->id_user_adaugare."/".$model->nume_fisier_adaugare;
            $stare=\common\models\NomTipStare::find()->where(['id'=>$model->stare])->asArray()->all();
            ?>

            <iframe width="500px" height="400px" src="<?= $src?>"></iframe>;

        </div>
        <div>
            <p><b>Dată adăugare:</b> <?= $model->data_adaugare?> </p>

            <p><b>Nume fișier: </b><?= $model->nume_fisier_afisare?></p>
            <p><b>Stare: </b>
                <?= $stare[0]['nume']?>
            </p>

        </div>

    </div>

</div>
<div>
    <br>
</div>