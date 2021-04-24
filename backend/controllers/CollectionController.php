<?php
namespace backend\controllers;

use Unsplash;
use Yii;
use backend\models\UnsplashSearchForm;
use common\models\Collection;
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
                        'actions' => ['index', 'show'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => [],
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

       $user = Yii::$app->user->identity;

       return $this->render('index', [
            'user' => $user,
        ]);

    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionShow($id)
    {

        $collection = Collection::find($id)->one();

        return $this->render('show', [
            'collection' => $collection,
        ]);

    }

}
