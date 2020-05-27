<?php

namespace App\Action;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use App\Components\UserRole;

final class HomeAction
{

    private $userRole;

    public function __construct( UserRole $userRole ){
        
        $this->userRole = $userRole;

    }
    
    public function __invoke(ServerRequest $request, Response $response)
    {

        //$info = $request->getParsedBody();
        
        $data = $this->userRole->getRole(800);

        if($data){

            return $response->withJson($data);
        }
        return $response->withJson("estoy en nulo");
    }
}