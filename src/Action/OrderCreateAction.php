<?php

namespace App\Action;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use App\Components\UserDecode;
use App\Domain\Order\Data\OrderCreateData;
use App\Domain\Order\Service\OrderCreate;



final class OrderCreateAction{

    private $orderCreate;

    public function __construct(OrderCreate $orderCreate){

        $this->orderCreate = $orderCreate;

    }

    public function __invoke(ServerRequest $request, Response $response){

        $data = new OrderCreateData($request->getParsedBody());

        $send = $this->orderCreate->createOrder($data); #ver como enviar estos datos luego!!

        if ($send['exception']) {
            
            return $response->withJson("Error al crear pedido, titulos repetidos", 400);
            
        } 
        
        return $response->withJson($send, 201);

    }
}
