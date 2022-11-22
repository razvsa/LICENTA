<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\KeyAnuntPostVacant;
/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posturi Vacante', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>
<div class="post-vacant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_nom_tip_functie',
            'pozitie_stat_organizare',
            'denumire',
            'cerinte',
            'id_nom_judet',
            'id_nom_nivel_studii',
            'id_nom_nivel_cariera',
            'oras',
        ],
    ]);
        $info=KeyAnuntPostVacant::find()->where(['id_post_vacant'=>$model->id])->select(['id_anunt'])->asArray()->all();
//        echo'<pre>';
//        print_r($info);
//        echo'</pre>';
//        die();
    ?>

    <?php echo Html::a('OK',['/anunt/index'],['class'=>'btn btn-success'])?>
    <?php echo Html::a('Vizualizeaza celelalte posturi ale anuntului',['post-vacant/index','id'=>$info[0]['id_anunt']],['class'=>'btn btn-success'])?>

</div>
