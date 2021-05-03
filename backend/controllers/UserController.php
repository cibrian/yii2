<?php
namespace backend\controllers;

use Unsplash;
use Yii;
use common\models\Collection;
use common\models\CollectionPhoto;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Collection controller
 */
class UserController extends Controller
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
                        'actions' => ['index','edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'edit' => ['get','post'],
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
        return $this->render('index');
    }

    public function actionEdit($id)
    {
        $model = new User;
        if(($request = Yii::$app->request->post()) && $model->validate()) {
            $user = $model::find()->where(['id'=>$id])->one();
            $user->username = $request['User']['username'];
            $user->email = $request['User']['email'];
            $user->is_admin = $request['User']['is_admin'];
            $user->save();
            $this->redirect(array('user/index'));
        }
        $user = User::find()->where(['id' => $id])->one();
        return $this->render('edit', [
            'user' => $user,
        ]);
    }


}
