<?php

/** @var backend\controllers\CandidatFisierController $posturi */
/** @var backend\controllers\CandidatFisierController $status */

?>

<?php
if($status==1)
    echo '<br><h3>Posturile din cadrul structurii, pentru care trebuie aprobate dosare</h3>';
else if($status==3)
    echo '<br><h3>Dosare aprobate in functie de posturi</h3>';
echo '<br>';
?>


<div >
    <?php
    echo \yii\widgets\ListView::widget([

        'dataProvider'=>$posturi,
        'itemView'=>'_post_item',
        'viewParams' => ['status' => $status],
        'summary' =>''
    ])?>
</div>