<?php

namespace App\Action;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use App\Components\UserDecode;
use App\Domain\Order\Service\OrderCreate;

final class OrderCreateAction{

    private $userDecode;

    private $orderCreate;

    public function __construct(UserDecode $userDecode, OrderCreate $orderCreate){

        $this->userDecode = $userDecode;
        $this->orderCreate = $orderCreate;

    }

    public function __invoke(ServerRequest $request, Response $response){

        $numVendedor = 401;//$this->userDecode->getSeller($request);



        return $response->withJson($numVendedor);
    }
}