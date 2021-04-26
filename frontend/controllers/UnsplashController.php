<?php
namespace frontend\controllers;

use Unsplash;
use Yii;
use common\models\CollectionPhoto;
use common\models\User;
use frontend\models\UnsplashSearchForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class UnsplashController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','search'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'search' => ['post'],
                    'updateCollection' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new UnsplashSearchForm;
        $user = User::find()->where([
                'id' => (Yii::$app->user->identity)->id
            ]
        )->with('collections.photos')->one();

        $collections = [];
        foreach ($user->collections as $collection) {
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

        return $this->render('index', [
            'model' => $model,
            'user' => $user,
            'collections' => json_encode($collections),
        ]);
    }


    public function actionSearch()
    {

        Unsplash\HttpClient::init([
            'applicationId' => 'f8ulmBmgZ7QYMM4Jvn_lFpAbU9-oh2whhAvaQatoSCk',
            'secret'    => 'crrX0Hwgm0siUFB6suZtTjvJ6NmkZ2eL1BW8TLkPtFA',
            'callbackUrl'   => 'https://your-application.com/oauth/callback',
            'utmSource' => 'NAME OF YOUR APPLICATION'
        ]);

        $request = Yii::$app->request;
        $user = Yii::$app->user->identity;

        $query = $request->post('UnsplashSearchForm')['query'];

        $result = Unsplash\Search::photos($query, 1, 12,'landscape')->getResults();
        $photos = [];

        foreach ($result as $photo) {
            $photos[] = [
                'id'=>$photo['id'],
                'urls'=>$photo['urls'],
                'description' =>$photo['alt_description'],
            ];
        }

        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'data' => [
                'photos' => $photos,
            ],
        ]);
    }

}
