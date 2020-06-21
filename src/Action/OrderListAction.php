<?php

namespace App\Action;

use App\Domain\Order\Service\OrderList;
use Slim\Http\Response;
use Slim\Http\ServerRequest;


final class OrderListAction
{

    private $orderList;

    public function __construct(OrderList $orderList){

        $this->orderList = $orderList;

    }

    public function __invoke(ServerRequest $request, Response $response, array $args)
    {
        $prueba = $request->getParsedBody();
        
        $resp = $this->orderList->getOrders($args);

        
        return $response->withJson($resp, 200);

    }


}