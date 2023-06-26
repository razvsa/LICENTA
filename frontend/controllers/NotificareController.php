<?php

namespace frontend\controllers;

use common\models\Notificare;
use common\models\NotificareSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificareController implements the CRUD actions for Notificare model.
 */
class NotificareController extends Controller
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
     * Lists all Notificare models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $notificari=new ActiveDataProvider([
            'query'=>Notificare::find()->where(['id_user'=>\Yii::$app->user->id])->orderBy(['data_adaugare'=>SORT_DESC])
        ]);
        if(\Yii::$app->user->isGuest)
            return $this->render('/site/error', [
            ]);

        return $this->render('index', [
            'notificari' => $notificari,
        ]);
    }

    /**
     * Displays a single Notificare model.
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
     * Creates a new Notificare model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Notificare();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Notificare model.
     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param int $id ID
//     * @return string|\yii\web\Response
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Deletes an existing Notificare model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param int $id ID
//     * @return \yii\web\Response
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Notificare model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Notificare the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notificare::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCitittot()
    {
        $notificari=Notificare::find()
            ->where(['stare_notificare'=>2])->all();
        foreach ($notificari as $item) {
            $item->stare_notificare=1;
            $item->save();
        }
        \Yii::$app->response->redirect(['/notificare/index']);
    }
}
