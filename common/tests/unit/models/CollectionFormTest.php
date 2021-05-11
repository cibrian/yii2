<?php

namespace common\tests\unit\models;


use Mockery;
use Codeception\Test\Unit;
use common\models\CollectionForm;

class CollectionFormTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before() {}

    public function testShouldSucceed()
    {
        $model = Mockery::mock(CollectionForm::className())->makePartial();
        $model->shouldReceive('isDuplicated')->andReturn(false);
        $model->attributes = [
            'name' => "Dogs Album"
        ];
        expect($model->validate())->true();
        expect($model->hasErrors())->false();
    }

    public function testShouldFailIfDuplicatedName()
    {
        $model = Mockery::mock(CollectionForm::className())->makePartial();
        $model->shouldReceive('isDuplicated')->andReturn(true);
        $model->attributes = [
            'name' => "Dogs Album"
        ];
        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('name'))->equals('Duplicated name.');
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
