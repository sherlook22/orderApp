<?php

namespace App\Action;

use App\Domain\User\Service\UserListData;
use Slim\Http\Response;
use Slim\Http\ServerRequest;


final class UserListAction{

    private $userListData;

    public function __construct(UserListData $userListData){

        $this->userListData = $userListData;

    }

    public function __invoke(ServerRequest $request, Response $response, array $args):?Response
    {

        $vend = $this->userListData->listUser($args);

        return $response->withJson($vend, 200);

    }


}