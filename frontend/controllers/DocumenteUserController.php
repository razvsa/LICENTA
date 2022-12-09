<?php

namespace frontend\controllers;

use common\models\DocumenteUser;
use common\models\CandidatFisier;
use common\models\NomTipFisierDosar;
use common\models\search\DocumnteUserSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * DocumenteUserController implements the CRUD actions for DocumenteUser model.

 */
class DocumenteUserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all DocumenteUser models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DocumnteUserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocumenteUser model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DocumenteUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_post)
    {
        $model = new DocumenteUser();

        $tip_fisier=NomTipFisierDosar::find()->all();
        $document=[];
        foreach($tip_fisier as $tf){
            $document[]=new CandidatFisier();
        }

        $fis=new CandidatFisier();
        if ($model->load($this->request->post())) {
            //CV
            $fis->cale_fisier=$model->CV;
            $fis->data_adaugare=date('Y-m-d H:i:s');
            $fis->descriere="desc";
            $fis->id_post=$id_post;
            $fis->id_user_adaugare=Yii::$app->user->identity->id;;
            $fis->nume_fisier_afisare="afisareCV";
            $fis->nume_fisier_adaugare="adaugareCV";
            $fis->save();
            }
        foreach ($tip_fisier as $key=>$tf){
            $document[$key]->id_nom_tip_fisier_dosar=$tf->id;
        }
        return $this->render('create', [
            'model' => $model,
            'document'=>$document,
            'tip_fisier'=>$tip_fisier,
        ]);
    }

    /**
     * Updates an existing DocumenteUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumenteUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocumenteUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DocumenteUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumenteUser::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
