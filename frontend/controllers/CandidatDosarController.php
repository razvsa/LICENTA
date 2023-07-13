<?php

namespace frontend\controllers;

use common\models\Anunt;
use common\models\CandidatDosar;
use common\models\CandidatFisier;
use common\models\KeyInscrierePostUser;
use common\models\KeyTipFisierDosarTipCategorie;
use common\models\NomTipFisierDosar;
use common\models\PostVacant;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CandidatDosarController implements the CRUD actions for CandidatDosar model.
 */
class CandidatDosarController extends Controller
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
     * Lists all CandidatDosar models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(!\Yii::$app->user->isGuest) {
            $dataProvider = new ActiveDataProvider([
                'query' => CandidatDosar::find()
                    ->where(['id_user' => \Yii::$app->user->id]),

            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
        else
            return "Nu ai acces la acesta sectiune";
    }

    /**
     * Displays a single CandidatDosar model.
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
     * Creates a new CandidatDosar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
//    public function actionCreate()
//    {
//        $model = new CandidatDosar();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing CandidatDosar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing CandidatDosar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the CandidatDosar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CandidatDosar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CandidatDosar::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStergedosar($id_dosar){

        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
        $fisiere=CandidatFisier::find()
            ->where(['id_candidat_dosar'=>$id_dosar])->all();
        foreach($fisiere as $f){
            unlink(\Yii::getAlias('@frontend').$f['cale_fisier']);
            $f->delete();

        }

        FileHelper::removeDirectory(\Yii::getAlias('@frontend')."web\storage\user_".\Yii::$app->user->id."\dosar_post_".$dosar['id_post_vacant']);
        $key=KeyInscrierePostUser::find()
            ->where(['id_user'=>\Yii::$app->user->id,'id_post'=>$dosar['id_post_vacant']])->one();
        if($key!=null)
            $key->delete();

        $dosar->delete();
        \Yii::$app->response->redirect('index');
    }
    public function actionCompleteazadosar($id_dosar){
        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
        $fisiere_de_completat=$dosar->getDocumenteLipsa();
        $params=[
            'id_post' => $dosar->id_post_vacant,
            'fisiere' => $fisiere_de_completat,
            'validare'=>4
        ];
        $security = \Yii::$app->getSecurity();
        $encryptionKey = 'cheia_de_criptare_secreta';
        $dataToEncrypt = http_build_query($params);
        $encryptedData = $security->encryptByPassword($dataToEncrypt, $encryptionKey);
        \Yii::$app->response->redirect(['/documente-user/create','params'=>$encryptedData]);
    }
}
