<?php

namespace backend\controllers;

use common\models\Anunt;
use common\models\KeyAnuntPostVacant;
use common\models\NomLocalitate;
use common\models\PostVacant;
use common\models\search\AnuntSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use Yii;

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
                'access'=>[
                    'class'=>AccessControl::class,
                    'rules'=>[
                        [
                            'allow'=>true,
                            'roles'=>['@']
                        ]
                    ]
                ],
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
        $dataProvider = $searchModel->search($this->request->queryParams);
        $localitati=(new \yii\db\Query())->select(['oras'])->from('post_vacant')->distinct()->all();
        $nivel_studii=(new \yii\db\Query())->select(['id','nume'])->from('nom_nivel_studii')->distinct()->all();
        $functie=(new \yii\db\Query())->select(['id','nume'])->from('nom_tip_incadrare')->distinct()->all();
        $nivel_cariera=(new \yii\db\Query())->select(['id','nume'])->from('nom_nivel_cariera')->distinct()->all();
        if($searchModel->load(Yii::$app->request->get()))
        {
            $dataProvider = $searchModel->search($this->request->queryParams);
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
        $anunt=Anunt::findOne(['id'=>$id]);
        $posturi = new ActiveDataProvider([
            'query'=>PostVacant::find()
                ->innerJoin(['apv'=>KeyAnuntPostVacant::tableName()],'apv.id_post_vacant=post_vacant.id')
                ->andWhere(['apv.id_anunt'=>$id])]);
        if($anunt->id_structura!=Yii::$app->user->getIdentity()->admin)
            return "Nu ai drepturi pentru acest post";
        return $this->render('view', [
            'model' => $this->findModel($id),
            'posturi'=>$posturi,
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

            if ($model->load($this->request->post())) {

                $model->id_user_adaugare=Yii::$app->user->identity->id;
                $model->data_postare=date('Y-m-d H:i:s');
                if(Yii::$app->user->getIdentity()->admin!=0)
                    $model->id_structura=Yii::$app->user->getIdentity()->admin;
                $model->save();
                return $this->redirect(['view','id'=>$model->id]);
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
                $out=NomLocalitate::find()->where(['id_nom_judet'=>$id_judet])->select(['id','nume as name'])->asArray()->all();
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
    public function actionStergeAnunt($id){
        $anunt=Anunt::findOne(['id'=>$id]);
        $anunt->delete();
        $posturi=PostVacant::find()->select('post_vacant.id')
            ->innerJoin(['key'=>KeyAnuntPostVacant::tableName()],'post_vacant.id=key.id_post_vacant')
            ->innerJoin(['anunt'=>Anunt::tableName()],'anunt.id=key.id_anunt')
            ->where(['anunt.id'=>$id])->all();

        foreach($posturi as $post){
            $post->delete();
        }
        return $this->redirect(['index']);
    }
}
