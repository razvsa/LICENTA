<?php

namespace frontend\controllers;

use common\models\Jobs;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class JobsController extends Controller
{
    public function actionIndex()
    {
        $dataProvider=new ActiveDataProvider([
            'query'=>Jobs::find()
        ]);
        return $this->render('index',[
            'dataProvider'=>$dataProvider,
            'itemView'=>'_jobs_item'
        ]);
    }
}