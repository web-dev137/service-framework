<?php


namespace Tests\Api;

use Codeception\Util\Fixtures;
use Tests\Support\ApiTester;

class PostApiCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function index(ApiTester $I)
    {
        $I->sendGet("post");
        $I->seeResponseCodeIs(200);
    }

    public function create(ApiTester $I)
    {
        $I->sendPost(
            "post/create",
            ["post"=>"New Post For My Blog5"]
        );
        $I->seeResponseCodeIs(200);
    }

    public function wrongCreate(ApiTester $I)
    {
        $I->sendPost("post/create");
        $I->seeResponseCodeIs(500);
        $I->seeResponseContainsJson(['data'=>['message'=>'Not valid']]);
    }

    public function view(ApiTester $I)
    {
        $I->sendGet('post/view',['id'=>1]);
        $I->seeResponseCodeIs(200);
    }

    public function wrongView(ApiTester $I)
    {
        $I->sendGet('post/view');
        $I->seeResponseCodeIs(400);
    }

}
