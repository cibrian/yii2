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
                'dataFile' => codecept_data_dir() . 'collections.php',
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
        $I->fillField('input[name="CollectionForm[name]"]', "Collection 1");
        $I->click("#create");
        $I->see('Collection 1');
        $I->seeRecord('common\models\Collection', array('name' => 'Collection 1', 'user_id' => 1));
    }

    public function testShouldFailIfDuplicatedName(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage("collection/index");
        $I->see('New Collection');
        $I->click("#newCollection");
        $I->fillField('input[name="CollectionForm[name]"]', "Guinea Pigs");
        $I->click("#create");
        $I->see('There was an error creating a new collection. Duplicated Name.');
    }

    public function testShouldFailIfUserIsNotLogged(FunctionalTester $I)
    {
        $I->amOnPage("collection/index");
        $I->dontSee('Search photo on Unsplash');
        $I->see('Login','h1');
    }
}