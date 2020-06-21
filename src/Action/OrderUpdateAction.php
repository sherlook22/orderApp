<?php

namespace App\Action;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use App\Domain\Order\Service\OrderUpdate;


final class OrderUpdateAction
{
    private $orderUpdate;

    public function __construct( OrderUpdate $orderUpdate )
    {

        $this->orderUpdate = $orderUpdate;

    }


    public function __invoke( ServerRequest $request, Response $response ) 
    {

        $val = $this->orderUpdate->recepcion($request->getParsedBody());



        return $response->withJson($val);

    }

}
