<?php

namespace App\Action;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use App\Components\SendPedido;

final class HomeAction
{

    private $sendPedido;

    public function __construct( SendPedido $sendPedido ){
        
        $this->sendPedido = $sendPedido;

    }
    
    public function __invoke(ServerRequest $request, Response $response)
    {

        $this->sendPedido->enviar();
        
    }
}