<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use Unsplash;

class UnsplashClient extends Component
{
	function __construct()
	{
		Unsplash\HttpClient::init([
            'applicationId' => 'f8ulmBmgZ7QYMM4Jvn_lFpAbU9-oh2whhAvaQatoSCk',
            'secret'    => 'crrX0Hwgm0siUFB6suZtTjvJ6NmkZ2eL1BW8TLkPtFA',
            'callbackUrl'   => 'https://your-application.com/oauth/callback',
            'utmSource' => 'NAME OF YOUR APPLICATION'
        ]);
	}

	public function search($query)
	{
        $result = Unsplash\Search::photos($query, 1, 12,'landscape')->getResults();

        $objectResult = Unsplash\Search::photos($query, 1, 12,'landscape')->getResults();
        $arrayResult = [];

        foreach ($objectResult as $row) {
            $arrayResult[] = [
                'id'=>$row['id'],
                'urls'=>$row['urls'],
                'description' =>$row['alt_description'],
            ];
        }

        return $arrayResult;
	}

}