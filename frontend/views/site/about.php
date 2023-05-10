<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap\Modal;



$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('D:\xamp\htdocs\eJobs\frontend\web\css\site.css');
$data='07/30/2024';

//$mailer = Yii::$app->mailer;
//$message = $mailer->compose()
//    ->setFrom('from@example.com')
//    ->setTo('razvansacaliuc@gmail.com')
//    ->setSubject('Subject of the Email')
//    ->setTextBody('Text body of the email')
//    ->setHtmlBody('<b>HTML body of the email</b>');
//
//$result = $message->send();
//
//if ($result) {
//    echo 'Email sent successfully!';
//} else {
//    echo 'Failed to send email.';
//}

Yii::$app->mailer->compose()
    ->setFrom('ejobs.mai.gov@gmail.com')
    ->setTo('razvansacaliuc@gmail.com')
    ->setSubject("fbfbfkhsf")
    ->send();


?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>



