<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\authclient\widgets\AuthChoice;


$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('D:\xamp\htdocs\eJobs\frontend\web\css\site.css');
$data='07/30/2024';

echo Html::a('Notificări', ['anunt/index'], ['id' => 'my-custom-button2']);

?>
ă
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>



