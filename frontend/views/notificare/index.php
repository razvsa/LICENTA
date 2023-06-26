<?php

use common\models\Notificare;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\NotificareSearch $notificari */

$this->title = 'Notificari';
$canal='my-channel'.Yii::$app->user->id;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('https://js.pusher.com/7.2/pusher.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$canal="my-channel".Yii::$app->user->id;
$this->registerJs(<<<JS
$(document).ready(function() {

        var pusher = new Pusher('2eb047fb81e4d1cc5937', {
            cluster: 'eu'
        });
        
        var channel = pusher.subscribe("$canal");
        channel.bind('my-event', function(data) {
            $.pjax.reload("#pjax-notificare");
});


    });
JS);
?>
<div class="notificare-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo Html::a('Marchează ca citit',['/notificare/citittot'],['class'=>'btn btn-outline-info']);
    \yii\widgets\Pjax::begin(['id'=>'pjax-notificare']);
    echo'<br><br>';

    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$notificari,
        'itemView'=>'_notificari_item',
        'emptyText' => 'Nu aveti notificari',
        'summary' =>''
    ]);
    \yii\widgets\Pjax::end();
    ?>


</div>
