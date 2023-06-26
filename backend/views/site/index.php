<?php

/** @var yii\web\View $this */

$this->title = 'eJobs Admin';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <style>
        /* Stilizare pentru aspectul paginii */
        body {

            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            color: #333333;
            font-size: 36px;
            margin-bottom: 20px;
        }

        p {
            color: #666666;
            font-size: 18px;
            margin-bottom: 40px;
        }

        .stats {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
        }

        .stats-item {
            flex: 1;
            padding: 10px;
            background-color: #ffffff;
            border-radius: 4px;
            margin: 0 10px;
        }

        .stats-item h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .stats-item p {
            font-size: 16px;
            color: #888888;
            margin: 0;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #FF6600;
            color: #ffffff;
            font-size: 16px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        /*.cta-button:hover {*/
        /*    background-color: #CC5500;*/
        /*}*/
    </style>
</head>
<body>
<div class="container">
    <br>
    <h1>Bun venit pe pagina de adminsitrator a site-ului!</h1>
    <br>
    <div class="stats">
        <div class="stats-item">
            <h2>Utilizatori</h2>
            <p><?= \common\models\User::find()->where(['admin'=>-1])->count()?></p>
        </div>
        <div class="stats-item">
            <h2>Posturi postate</h2>
            <p><?=\common\models\PostVacant::find()
                    ->innerJoin(['a'=>\common\models\Anunt::tableName()],'a.id=post_vacant.id_anunt')
                    ->where(['a.postat'=>1])->count()?></p>
        </div>
        <div class="stats-item">
            <h2>Dosare</h2>
            <p><?=\common\models\CandidatDosar::find()->count()?></p>
        </div>
    </div>
    <?=\yii\helpers\Html::a('Vezi anunțuri',['anunt/index'],['class'=>'btn btn-outline-info'])?>

</div>
</body>
</html>


