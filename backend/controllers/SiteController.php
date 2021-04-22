<?php
namespace backend\controllers;

use Unsplash;
use Yii;
use backend\models\UnsplashSearchForm;
use common\models\LoginForm;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $model = new UnsplashSearchForm;
        $user = Yii::$app->user->identity;

        $u = User::find($user->id)->with('collections.photos')->one();


        $collections = [];
        foreach ($u->collections as $collection) {
            $photos=[];
            foreach ($collection->photos as $photo) {
                $photos[] = $photo->photo_id;
            }
            $collections[] = [
                'id' => $collection->id,
                'name' => $collection->name,
                'photos' => $photos
            ];
        }


        Unsplash\HttpClient::init([
            'applicationId' => 'f8ulmBmgZ7QYMM4Jvn_lFpAbU9-oh2whhAvaQatoSCk',
            'secret'    => 'crrX0Hwgm0siUFB6suZtTjvJ6NmkZ2eL1BW8TLkPtFA',
            'callbackUrl'   => 'https://your-application.com/oauth/callback',
            'utmSource' => 'NAME OF YOUR APPLICATION'
        ]);

        return $this->render('index', [
            'model' => $model,
            'user' => $u,
            'collections' => json_encode($collections),
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionTest()
    {
        return [
            'data' => [
                'success' => true,
                'model' => null,
                'message' => 'An error occured.',
            ],
        ];
    }

}
