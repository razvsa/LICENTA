<?php

namespace frontend\controllers;

use common\models\Anunt;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\elasticsearch\Connection;
use yii\elasticsearch\Query;
use yii\elasticsearch\ActiveRecord;
use Elasticsearch\ClientBuilder;
use yii\helpers\Url;
use Google\Auth\OAuth2;



/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionGoogleAuth()
    {
        $client = Yii::$app->google;
        echo '<pre>';
        print_r($client);
        die;
        echo '</pre>';
        $client->setReturnUrl(Url::to(['site/google-auth'], true));


        $client->setViewOptions([
            'popupWidth' => 500,
            'popupHeight' => 500,
        ]);

        $authUrl = $client->buildAuthUrl();
        $this->redirect($authUrl);
    }

    public function actionGoogleCallback()
    {
        $client = Yii::$app->google;
        $client->setReturnUrl(Url::to(['site/google-auth'], true));
        $authData = $client->authenticate();
        $userAttributes = $client->getUserAttributes();
        $this->redirect(['site/index']);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
//        $pythonScript ='D:\script.py';
//        $command = escapeshellcmd("python " . $pythonScript ." D:\poza1.jpeg");
//        $output = shell_exec($command);
//        $parts = explode('/', $output);
//        $date = new \DateTime();
//        $date->setDate($parts[2], $parts[1], $parts[0]);
//        $currentDate = new \DateTime();
//
//        if ($date < $currentDate) {
//            echo "Data este in trecut";
//        } elseif ($date > $currentDate) {
//            echo "Data este in viitor";
//        } else {
//            echo "Data este identică cu timpul curent.";
//        }


//        $connection = new Connection();
//        $query = new Query();
//        $anunturi=Anunt::find()->asArray()->all();
//        $command=$connection->createCommand();
//
//
//
//        foreach ($anunturi as $anunt){
//            $command->insert('anunt','_doc',$anunt);
//        }
//
//        $query->from('anunt')
//            ->query([
//                'multi_match' => [
//                    'query' => 'ani',
//                    'fields' => ['*'],
//                    'fuzziness' => 2,
//                    'prefix_length' => 2,
//                ]
//            ]);
//        $results = $query ->all();
//        $rezultate = array_column($results, '_source');
//        $lista_id=[];
//        $rezultate_finale=[];
//        foreach ($rezultate as $rezultat){
//            if(!in_array($rezultat['id'],$lista_id)) {
//                array_push($rezultate_finale, $rezultat);
//                array_push($lista_id,$rezultat['id']);
//            }
//        }

        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
//    public function actionError()
//    {
//        return ""
////        $this->layout = 'error'; // Setarea unei machete personalizate pentru pagina de eroare
////        $exception = Yii::$app->errorHandler->exception;
////        if ($exception !== null) {
////            return $this->render('error', ['exception' => $exception]);
////        } else {
////            return $this->render('error');
////        }
//    }
}
