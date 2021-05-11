<?php

namespace common\tests\unit\models;


use Codeception\Test\Unit;
use common\models\CollectionForm;

class UnsplashSearchFormTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before() {}

    public function testShouldSucceed()
    {
        $model = new CollectionForm();
        $model->attributes = [
            'name' => "Dogs Album"
        ];
        expect($model->validate())->true();
        expect($model->hasErrors())->false();
    }

    public function testShouldFailIfEmptyName()
    {
        $model = new CollectionForm();
        $model->attributes = [
            'name' => ''
        ];
        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('name'))->equals('Name cannot be blank.');
    }

}
