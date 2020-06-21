<?php

namespace App\Action;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use App\Domain\Order\Service\SearchOrder;


final class SearchAction {

    private $searchOrder;

    public function __construct( SearchOrder $searchOrder ) 
    {

        $this->searchOrder = $searchOrder;

    }

    public function __invoke( ServerRequest $request, Response $response, Array $args )
    {

        $resp = $this->searchOrder->busca($args);        
        
        if ($resp['empty']) {
            return $response->withJson([], 200);
            
        }elseif ($resp['exception']) {
            return $response->withJson($resp, 400);

        }else {
            return $response->withJson($resp, 200);
        }

    }

}
