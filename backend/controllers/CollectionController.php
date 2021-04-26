<?php
namespace backend\controllers;

use Unsplash;
use Yii;
use backend\models\UnsplashSearchForm;
use common\models\Collection;
use common\models\CollectionPhoto;
use common\models\LoginForm;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Collection controller
 */
class CollectionController extends Controller
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
                        'actions' => ['index', 'show', 'remove', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
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


    public function actionIndex()
    {

       $user = Yii::$app->user->identity;
       $model = new UnsplashSearchForm;

       return $this->render('index', [
            'user' => $user,
            'model' => $model,
        ]);

    }


    public function actionShow($id)
    {

        $collection = Collection::find()->where(['id' => $id])->one();
        return $this->render('show', [
            'collection' => $collection,
        ]);

    }


    public function actionRemove()
    {

        $request = Yii::$app->request;

        $collectionId = $request->post('collection_id');
        $photoId = $request->post('photo_id');

        $collectionPhoto = CollectionPhoto::find()
            ->where(['collection_id'=>$collectionId])
            ->andwhere(['photo_id'=>$photoId])
            ->one();

        if ($collectionPhoto) {
            $collectionPhoto->delete();
        }


        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'data' => [
                'success' => true,
            ],
        ]);

    }

}
