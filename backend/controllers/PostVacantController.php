<?php

namespace backend\controllers;

use common\models\KeyInscrierePostUser;
use common\models\NomLocalitate;
use common\models\PostVacant;
use common\models\KeyAnuntPostVacant;
use common\models\search\PostVacantSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use Yii;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * PostVacantController implements the CRUD actions for PostVacant model.
 */
class PostVacantController extends Controller
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
     * Lists all PostVacant models.
     *
     * @return string
     */
    public function actionIndex($id)
    {

        $searchModel = new PostVacantSearch();
        $searchModel->id_virtual=$id;
        return $this->render('index', [
            'searchModel' => $searchModel,
        ]);
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
     * Creates a new PostVacant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {

        $model = new PostVacant();
        $model_key=new KeyAnuntPostVacant();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model_key->adauga($id,$model->id);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

    return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function downloadFile($fullpath){
        if(!empty($fullpath)){
            header("Content-type:application/xlsx");
            header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
            header('Content-Length: ' . filesize($fullpath));
            readfile($fullpath);
            unlink($fullpath);
            Yii::$app->end();
        }
    }
    public function actionListacandidati($id_post){

        $spreadsheet = new Spreadsheet();
        $post=PostVacant::findOne(['id' => $id_post]);



        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Index');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('E1', 'Nota');

        $header = User::find()->select(['username','email'])
            ->innerJoin(['kip'=>KeyInscrierePostUser::tableName()],'kip.id_user=user.id')
            ->where(['kip.id_post'=>$id_post])
            ->asArray()->all();
        $denumire_fisier='Candidati_post_'.$post->denumire.'.xlsx';


        $cou=count($header);
        $matrice=[];
        $vector=[];
        for($i=0;$i<$cou;$i++)
        {
            $valoare=$i+1;
            $vector[0]=$valoare;
            array_push($matrice,$vector);
        }

        $sheet->fromArray($matrice,NULL,'A3');
        $sheet->fromArray($header,NULL,'B3');

        $writer = new Xlsx($spreadsheet);
        $writer->save($denumire_fisier);

        $path=\Yii::getAlias("@backend") . "\web\\";
        $this->downloadFile($path.$denumire_fisier);

    }

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
