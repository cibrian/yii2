<?php
namespace frontend\controllers\api;

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
}