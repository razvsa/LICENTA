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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $posturi = new ActiveDataProvider([
            'query'=>PostVacant::find()
                ->innerJoin(['apv'=>KeyAnuntPostVacant::tableName()],'apv.id_post_vacant=post_vacant.id')
                ->andWhere(['apv.id_anunt'=>$id])]);
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
        //$model->cale_imagine=UploadedFile::getInstanceByName('image');
            if ($model->load($this->request->post())) {

                $model->id_user_adaugare=Yii::$app->user->identity->id;
                $model->data_postare=date('Y-m-d H:i:s');
                $model->cale_imagine="o cale";


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
}
