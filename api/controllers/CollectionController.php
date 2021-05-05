<?php
namespace api\controllers;

use Yii;
use common\models\Collection;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class CollectionController extends ActiveController
{
    public $modelClass = Collection::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],
        ];
        return $behaviors;
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->getIdentity()->id;
        $collections =  Collection::find()->where([
            'user_id' => $userId
        ])->with('photos')->asArray()->all();

        if (!$collections) {
            throw new NotFoundHttpException("Collections not found for User $userId");
        }

        return $collections;
    }

    public function actionView($id)
    {
        $collection = Collection::find()->where([
            'id' => $id,
            'user_id' => Yii::$app->user->getIdentity()->id
        ])->with('photos')->asArray()->one();

        if (!$collection) {
            throw new NotFoundHttpException("Collection $id not found.");
        }

        return $collection;
    }
}