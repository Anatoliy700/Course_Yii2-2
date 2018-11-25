<?php namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;

class LoginCest
{
    public function _before(AcceptanceTester $I) {
    }
    
    // tests
    public function tryToTest(AcceptanceTester $I) {
        $I->amOnPage('site/index');
        $I->wait(1); // wait for page to be opened
        $I->seeLink('Login');
        $I->wait(1); // wait for page to be opened
        $I->click('Login');
        $I->wait(1); // wait for page to be opened
        $I->see('Login', 'h1');
        $I->wait(1); // wait for page to be opened
        $I->fillField('Username', 'admin');
        $I->wait(1); // wait for page to be opened
        $I->fillField('Password', 'adminadmin');
        $I->wait(1); // wait for page to be opened
        $I->click('#login-form button[type=submit]');
        $I->wait(1); // wait for page to be opened
        $I->see('Logout');
    }
}
