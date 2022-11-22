<?php
/**@var $model \common\models\PostVacant */
?>
<div class="card">

    <div class="row">

        <div class="col-sm-3">
            <a href="<?= \yii\helpers\Url::to(['/post-vacant/view','id'=>$model->id])?>">
            <img class="card-img" src="https://www.revistafermierului.ro/media/k2/items/cache/f6fb20ea3c8f8dda3a193feb6151eea7_XL.jpg" >
            </a>
        </div>
    <div class="card-body col-sm-6">
        <h5 class="card-title"><?php echo $model->cerinte?></h5>
        <h5 class="card-title"><?php echo $model->oras?></h5>

    </div>
    </div>

</div>
<div>
    <br>
</div>
