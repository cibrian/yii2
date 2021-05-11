<?php

namespace frontend\tests\unit\models;


use Codeception\Test\Unit;
use common\fixtures\UserFixture;
use frontend\models\UnsplashSearchForm;

class UnsplashSearchFormTest extends Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testShouldSucceed()
    {
        $model = new UnsplashSearchForm();
        $model->attributes = [
            'query' => "cats"
        ];

        expect($model->validate())->true();
        expect($model->hasErrors())->false();
    }

    public function testShouldFailIfEmptyQuery()
    {
        $model = new UnsplashSearchForm();
        $model->attributes = [
            'query' => ''
        ];
        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('query'))->equals('Query cannot be blank.');
    }

}
