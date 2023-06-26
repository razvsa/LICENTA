<?php
/** @var common\models\CandidatFisier $model */
?>
<div class="card-footer">

    <div class="row">

        <div class="col-md-7">

            <?php
            $src="https://ejobs.mai.gov.ro".substr($model->cale_fisier, strpos($model->cale_fisier, "\storage"));
            $stare=\common\models\NomTipStare::find()->where(['id'=>$model->stare])->asArray()->all();
            $stare_afisare=0;
            if($stare[0]['id']==3)
            {
                $stare_afisare="<p class='alert alert-success'>Document valid</p>";
            }
            else if($stare[0]['id']==2){
                $stare_afisare="<p class='alert alert-warning'>Document în curs de validare</p>";
            }
            else{
                $stare_afisare="<p class='alert alert-danger'>Document respins</p>";
            }
            ?>

            <iframe width="500px" height="500px" src="<?= $src?>"></iframe>

        </div>
        <div>
            <p><b>Dată adăugare:</b> <?= $model->data_adaugare?> </p>

            <p><b>Nume fișier: </b><?= $model->nume_fisier_afisare?></p>
            <p><?=$stare_afisare?></p>

        </div>

    </div>

</div>
<div>
    <br>
</div>
<script>
    $('iframe').on('load', function() {
        var iframe = $(this)[0].contentWindow;
        iframe.addEventListener('mousewheel', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
                var zoom = iframe.document.body.style.zoom || '100%';
                zoom = parseInt(zoom) + e.deltaY / 100;
                if (zoom > 0) {
                    iframe.document.body.style.zoom = zoom + '%';
                }
            }
        });
    });
</script>
