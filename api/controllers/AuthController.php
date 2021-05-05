<?php

namespace api\controllers;

use Yii;
use common\models\LoginApiForm;
use common\models\LoginForm;
use common\models\User;
use yii\rest\ActiveController;

class AuthController extends ActiveController
{
    public $modelClass = User::class;

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    public function actionLogin()
    {
        $model = new LoginApiForm();
        if (
            $model->load(Yii::$app->getRequest()->getBodyParams(), '')
            && $model->login()
        ) {
            return [
                'access_token' => $model->login(),
            ];
        } else {
            return $model->getFirstErrors();
        }
    }
}