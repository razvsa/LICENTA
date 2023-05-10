<?php

namespace frontend\controllers;

use common\models\Anunt;
use common\models\AnuntFisier;
use common\models\KeyInscrierePostUser;
use common\models\PostFisier;
use common\models\PostVacant;
use common\models\search\AnuntSearch;
use common\models\search\PostVacantSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use common\models\NomLocalitate;
//use function Sodium\add;

/**
 * AnuntController implements the CRUD actions for Anunt model.
 */
class AnuntController extends Controller
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
     * Lists all Anunt models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnuntSearch();
        $dataProvider = $searchModel->search_user($this->request->queryParams);
        $localitati=(new \yii\db\Query())->select(['oras'])->from('post_vacant')->distinct()->all();
        $nivel_studii=(new \yii\db\Query())->select(['id','nume'])->from('nom_nivel_studii')->distinct()->all();
        $functie=(new \yii\db\Query())->select(['id','nume'])->from('nom_tip_incadrare')->distinct()->all();
        $nivel_cariera=(new \yii\db\Query())->select(['id','nume'])->from('nom_nivel_cariera')->distinct()->all();
        if($searchModel->load(Yii::$app->request->get()))
        {
            $dataProvider = $searchModel->search_user($this->request->queryParams);
        }
        Yii::$app->session->set('form', $this->request->queryParams);

//        echo '<pre>';
//        print_r($this->request->queryParams);
//        echo '</pre>';
//        die();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'localitati'=>$localitati,
            'functie'=>$functie,
            'nivel_studii'=>$nivel_studii,
            'nivel_cariera'=>$nivel_cariera,
        ]);
    }

    /**
     * Displays a single Anunt model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $titlu='Posturile Anuntului';
        $searchModel = new PostVacantSearch();
        $fisiere=new ActiveDataProvider([
            'query'=>AnuntFisier::find()->where(['id_anunt'=>$id])
        ]);
        $posturi = new ActiveDataProvider([
            'query'=>PostVacant::find()
                ->where(['id_anunt'=>$id])]);
        $nr_posturi=$posturi->getTotalCount();
        $model=Anunt::findOne(['id'=>$id]);
        return $this->render('view', [
            'searchModel' => $searchModel,
            'posturi' => $posturi,
            'titlu'=>$titlu,
            'model'=>$model,
            'posturilemele'=>0,
            'fisiere'=>$fisiere,
            'nr_posturi'=>$nr_posturi,

        ]);

    }

    public function actionAnunturilemele(){
        $anunturi=new ActiveDataProvider([
            'query'=>Anunt::find()
                ->innerJoin(['post'=>PostVacant::tableName()],'anunt.id=post.id_anunt')
                ->innerJoin(['key'=>KeyInscrierePostUser::tableName()],'post.id=key.id_post')
                ->where(['key.id_user'=>Yii::$app->user->id])
        ]);

        return $this->render('anunturilemele',[
            'anunturi'=>$anunturi
        ]);
    }

    /**
     * Creates a new Anunt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Anunt();

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

    public function actionGetLocalitate() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id_judet = $parents[0];
                $out=NomLocalitate::find()
                    ->innerJoin(['post'=>PostVacant::tableName()],'post.oras=nom_localitate.id')
                    ->where(['nom_localitate.id_nom_judet'=>$id_judet])->select(['nom_localitate.id','nom_localitate.nume as name'])->asArray()->all();
//                        echo '<pre>';
//        print_r($out);
//        echo '</pre>';
//        die();
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    /**
     * Updates an existing Anunt model.
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
     * Deletes an existing Anunt model.
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
     * Finds the Anunt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Anunt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anunt::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function downloadFileFaraStergere($fullpath){
        if(!empty($fullpath)){
            header("Content-type:application/zip");
            header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
            header('Content-Length: ' . filesize($fullpath));
            readfile($fullpath);
            \Yii::$app->end();
        }
    }
    public function actionDescarca($id){
        $fisier=AnuntFisier::findOne(['id'=>$id]);
        $cale_completa=\Yii::getAlias('@frontend').$fisier->cale_fisier;
        $this->downloadFileFaraStergere($cale_completa);
    }
}
