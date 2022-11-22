<?php
/**@var $model \common\models\Anunt */
?>
<div class="card">

    <div class="row">

        <div class="col-sm-3">
            <a href="<?= \yii\helpers\Url::to(['/post-vacant/index','id'=>$model->id])?>">
            <img class="card-img" src="https://www.revistafermierului.ro/media/k2/items/cache/f6fb20ea3c8f8dda3a193feb6151eea7_XL.jpg" >
            </a>
        </div>
    <div class="card-body col-sm-6">
        <h5 class="card-title"><?php echo $model->departament?></h5>
        <p class="card-title"><?php echo $model->descriere?></p>


    </div>
    </div>

</div>
<div>
    <br>
</div>