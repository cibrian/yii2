<?php

namespace console\controllers;

use Unsplash;
use yii\console\Controller;
use yii\console\widgets\Table;

class UnsplashController extends Controller
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

    public function actionSearch()
    {
        Unsplash\HttpClient::init([
            'applicationId' => 'f8ulmBmgZ7QYMM4Jvn_lFpAbU9-oh2whhAvaQatoSCk',
            'secret'    => 'crrX0Hwgm0siUFB6suZtTjvJ6NmkZ2eL1BW8TLkPtFA',
            'callbackUrl'   => 'https://your-application.com/oauth/callback',
            'utmSource' => 'NAME OF YOUR APPLICATION'
        ]);
        $result = (array)Unsplash\Search::photos($this->query, 1, 12,'landscape')->getResults();
        $photos = [];
        foreach ($result as $photo) {
            $photos[] = [
                $photo['id'],
                $photo['description'],
                $photo['urls']['raw'],
                $photo['user']['name'],
                $photo['created_at'],
            ];
        }
        echo Table::widget([
            'headers' => ['ID','Description','URL', 'User', 'Created At'],
            'rows' => $photos
        ]);
    }
}