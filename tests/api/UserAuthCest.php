<?php
namespace App\Tests;
use App\Kernel;
use App\Tests\ApiTester;
use Codeception\Util\Debug;

class UserAuthCest
{
    /**
     * @p
     */
    public function authUser(ApiTester $I)
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('https://127.0.0.1:8002/api/login_check', [
            'username' => 'admin1',
            'password' => 'admin'
        ]);

        $userManager =  $I->grabService('fos_user.user_manager')->findUserBy(["id" => 1]);
        $authenticationSuccessHandler = $I->grabService('lexik_jwt_authentication.jwt_manager');
        $token = $authenticationSuccessHandler->create($userManager);

        codecept_debug($token);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"token":"'.$token.'"}');
    }


}
