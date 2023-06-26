<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';


?>
<!DOCTYPE html>
<html>
<head>
    <title>Homepage - Căutare de Joburi</title>
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

        .cta-button:hover {
            background-color: #CC5500;
        }
    </style>
</head>
<body>
<div class="container">
    <br>
    <h1>Bun venit în aplicația pentru recrutare a Ministerului Afacerilor Interne</h1>
    <p>Găsiți cele mai recente oferte de locuri de muncă și începeți următoarea etapă a carierei dvs.</p>
    <?=\yii\helpers\Html::a('Vezi anunțuri',['anunt/index'],['class'=>'btn btn-outline-info'])?>
</div>
</body>
</html>

