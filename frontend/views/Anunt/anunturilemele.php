<?php
/** @var \frontend\controllers\AnuntController $anunturi */


echo '<br><h3>Aplicările mele: </h3><hr style="border-top: 1px solid black;">';
echo '<h5>Au fost găsite <b>'.$anunturi->count.'</b> anunțuri  </h5><br>';
echo \yii\widgets\ListView::widget([

    'dataProvider'=>$anunturi,
    'itemView'=>'_jobs_item',
    'summary' =>''
]);