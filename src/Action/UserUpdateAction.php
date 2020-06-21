<?php

namespace App\Action;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use App\Domain\User\Data\UserCreateData;
use App\Domain\User\Service\UserUpdate;

final class UserUpdateAction {

    private $userUpdate;

    public function __construct( UserUpdate $userUpdate )
    {

        $this->userUpdate = $userUpdate;

    }

    public function __invoke(ServerRequest $request, Response $response)
    {
        $user = new UserCreateData($request->getParsedBody());

        $resp = $this->userUpdate->update($user);

        if(!$res['exception']){
            return $response->withJson($resp, 200);
        }
        else{
            return $response->withJson($resp['exception'], 400);
        }
    }

}