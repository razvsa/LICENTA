<?php

namespace frontend\controllers;

use common\models\Jobs;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
    public function actionView($id)
    {
        $job=Jobs::findOne($id);
        if(!$job){
            throw new NotFoundHttpException("Job does not exist");
        }
        return $this->render('view',[
           'model'=>$job
        ]);
    }
}