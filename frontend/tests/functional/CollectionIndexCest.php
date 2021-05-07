<?php

namespace frontend\tests\functional;

use common\fixtures\CollectionFixture;
use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class CollectionIndexCest
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

    public function testShouldShowOnlyRelatedCollection(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage("collection/index");
        $I->see('Guinea Pigs');
        $I->see('Cats');
    }

    public function testShouldNotShowUnrelatedCollections(FunctionalTester $I)
    {
        $I->amLoggedInAs(2);
        $I->amOnPage("collection/index");
        $I->dontSee('Guinea Pigs');
        $I->dontSee('Cats');
    }

    public function testShouldCreateNewCollection(FunctionalTester $I)
    {
    	$I->amLoggedInAs(1);
        $I->amOnPage("collection/index");
        $I->see('New Collection');
        $I->click("#newCollection");
        $I->fillField('input[name="Collection[name]"]', "Collection 1");
        $I->click("#create");
        $I->see('Collection 1');
    }

    public function testShouldFailIfUserIsNotLogged(FunctionalTester $I)
    {
        $I->amOnPage("collection/index");
        $I->dontSee('Search photo on Unsplash');
        $I->see('Login','h1');
    }
}