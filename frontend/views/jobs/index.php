<?php
/** @var yii\web\View $this */
/** @var app\models\JobsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>
    <input id="search" name="search" placeholder="Search Here" class="form-control input-md" required value="" type="text">
<?php //$this->render('_search');
    echo \yii\widgets\ListView::widget([

        'dataProvider'=>$dataProvider,
        'itemView'=>'_jobs_item',
        'summary' =>''
])?>