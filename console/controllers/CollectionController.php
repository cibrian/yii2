<?php

namespace console\controllers;

use Unsplash;
use common\models\Collection;
use yii\console\Controller;
use yii\console\widgets\Table;

class CollectionController extends Controller
{
    public $query;

    public function options($actionID)
    {
        return ['query'];
    }

    public function optionAliases()
    {
        return ['q' => 'query'];
    }

    public function actionAll()
    {
        $collections = Collection::find()->asArray()->all();

        echo Table::widget([
            'headers' => ['ID','Collection Name','User'],
            'rows' => $collections
        ]);
    }

    public function actionFind($id)
    {
        $collection = Collection::findOne($id);

        echo Table::widget([
            'headers' => ['ID','Collection Name','User'],
            'rows' => [
                [$collection->id,$collection->name,$collection->user->username]
            ]
        ]);
    }
}