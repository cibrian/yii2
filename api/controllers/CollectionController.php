<?php
namespace api\controllers;

use Yii;
use common\models\Collection;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

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
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        return Collection::find()->where([
            'user_id' => Yii::$app->user->getIdentity()->id
        ])->with('photos')->asArray()->all();
    }

    public function actionView($id)
    {
        return Collection::find()->where([
            'id' => $id,
            'user_id' => Yii::$app->user->getIdentity()->id
        ])->with('photos')->asArray()->all();
    }
}