<?php
namespace frontend\controllers;

use Yii;
use common\models\Collection;
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

        $collections = Collection::find()->where([
            'user_id' =>Yii::$app->user->identity->id
        ])->with('photos')->asArray()->all();

        return $this->render('index', [
            'model' => $model,
            'collections' => $collections,
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
