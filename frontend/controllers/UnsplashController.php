<?php
namespace frontend\controllers;

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

        $request = Yii::$app->request;
        $query = $request->post('UnsplashSearchForm')['query'];

        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'data' => [
                'photos' => Yii::$app->unsplashClient->search($query),
            ],
        ]);
    }

}
