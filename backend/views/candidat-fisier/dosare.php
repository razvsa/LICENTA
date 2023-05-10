<?php
/** @var backend\controllers\CandidatFisierController $dosare */
/** @var backend\controllers\CandidatFisierController $status */

?>

<div >
    <br>
    <h4>Dosarele postului</h4>
    <br>
    <?php
    echo \yii\widgets\ListView::widget([

        'dataProvider'=>$dosare,
        'itemView'=>'_dosare_item',
        'viewParams' => ['status' => $status],
        'summary' =>''
    ])?>
</div>

