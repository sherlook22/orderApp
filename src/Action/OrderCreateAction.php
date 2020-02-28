<?php

namespace App\Action;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use App\Components\UserDecode;
use App\Domain\Order\Data\OrderCreateData;
use App\Domain\Order\Service\OrderCreate;

final class OrderCreateAction{

    private $userDecode;

    private $orderCreate;

    public function __construct(UserDecode $userDecode, OrderCreate $orderCreate){

        $this->userDecode = $userDecode;
        $this->orderCreate = $orderCreate;

    }

    public function __invoke(ServerRequest $request, Response $response){

        $user = 401;//$this->userDecode->getSeller($request);

        $data = new OrderCreateData($request->getParsedBody());

        $send = $this->orderCreate->createOrder($user,$data); #ver como enviar estos datos luego!!

        if (!$send['exception']) {
            return $response->withJson($send, 201);
        }

        return $response->withJson($send, 400);

    }
}