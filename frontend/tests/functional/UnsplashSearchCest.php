<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class UnsplashSearchCest
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
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    public function testShouldSucceed(FunctionalTester $I)
    {
    	$I->amLoggedInAs(1);
        $I->amOnPage("unsplash/index");
        $I->see('Search photo on Unsplash');
        $I->fillField('input[name="UnsplashSearchForm[query]"]', "Guinea Pig");
        $I->click('Search',"#search");
        $I->see('Brown And White Guinea Pig Eating Carrot');
    }

    public function testShouldFailIfUserIsNotLogged(FunctionalTester $I)
    {
        $I->amOnPage("unsplash/index");
        $I->dontSee('Search photo on Unsplash');
        $I->see('Login','h1');
    }
}