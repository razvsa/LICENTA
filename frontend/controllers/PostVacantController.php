<?php

namespace frontend\controllers;

use common\models\Anunt;
use common\models\CandidatDosar;
use common\models\CandidatFisier;
use common\models\KeyInscrierePostUser;
use common\models\PostFisier;
use common\models\PostVacant;
use common\models\search\PostVacantSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostVacantController implements the CRUD actions for PostVacant model.
 */
class PostVacantController extends Controller
{
    public $id_anunt;
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
     * Lists all PostVacant models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $titlu='Posturile Anuntului';
        $searchModel = new PostVacantSearch();
        $posturi = new ActiveDataProvider([
        'query'=>PostVacant::find()
            ->where(['id_anunt'=>$id])]);
        $anunt=Anunt::findOne(['id'=>$id]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'posturi' => $posturi,
            'titlu'=>$titlu,
            'anunt'=>$anunt,
            'posturilemele'=>0

        ]);
        return 0;
    }

    /**
     * Displays a single PostVacant model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
            'id_anunt'=>$id,
        ]);
    }

    /**
     * Creates a new PostVacant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
//    public function actionCreate()
////    {
////        $model = new PostVacant();
////
////        if ($this->request->isPost) {
////            if ($model->load($this->request->post()) && $model->save()) {
////                return $this->redirect(['view', 'id' => $model->id]);
////            }
////        } else {
////            $model->loadDefaultValues();
////        }
////
////        return $this->render('create', [
////            'model' => $model,
////        ]);
//    }

    /**
     * Updates an existing PostVacant model.
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


    public function actionRenunta($id_post,$id_user){

        $dosar=CandidatDosar::findOne(['id_post_vacant'=>$id_post]);
        $fisiere=CandidatFisier::find()
            ->where(['id_candidat_dosar'=>$dosar['id']])->all();
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

        return $this->redirect('/anunt/index');
    }
    /**
     * Deletes an existing PostVacant model.
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
     * Finds the PostVacant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PostVacant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostVacant::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
