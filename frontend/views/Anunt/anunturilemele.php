<?php
/** @var \frontend\controllers\AnuntController $anunturi */


echo '<br><h3>Aplicarile mele: </h3><hr style="border-top: 1px solid black;">';
echo '<h5>Au fost gasite <b>'.$anunturi->count.'</b> anunturi  </h5><br>';
echo \yii\widgets\ListView::widget([

    'dataProvider'=>$anunturi,
    'itemView'=>'_jobs_item',
    'summary' =>''
]);