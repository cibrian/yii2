<?php

namespace frontend\tests\functional;

use common\fixtures\CollectionFixture;
use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class CollectionShowCest
{

	/**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'usercollections.php'
            ],
            'collection' => [
                'class' => CollectionFixture::className(),
                'dataFile' => codecept_data_dir() . 'collection.php',
            ]
        ];
    }

    public function testShouldSucceed(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage(['collection/show', 'id' => 1]);
        $I->see('Guinea Pigs','h1');
        $I->see('Edit','button');
        $I->see('Delete','button');
        $I->see('View Slideshow','button');
        $I->see('Download','button');
    }

    public function testShouldUpdateExistingCollection(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage(['collection/show', 'id' => 1]);
        $I->click("#editFormBtn");
        $I->fillField('input[name="Collection[name]"]', "G. Pig");
        $I->click("#update");
        $I->seeRecord('common\models\Collection', array('name' => 'G. Pig', 'id' => 1));
        $I->dontSeeRecord('common\models\Collection', array('name' => 'Guinea Pigs', 'id' => 1));
    }

    public function testShouldDeleteCollection(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage(['collection/show', 'id' => 1]);
        $I->click("#delete");
        $I->dontSeeRecord('common\models\Collection', array('id' => 1));
    }

}