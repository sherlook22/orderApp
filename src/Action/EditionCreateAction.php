<?php

namespace App\Action;

use App\Domain\Edition\Data\EditionCreateData;
use App\Domain\Edition\Service\EditionCreate;
use Slim\Http\Response;
use Slim\Http\ServerRequest;


final class EditionCreateAction{

    private $editionCreate;

    public function __construct(EditionCreate $editionCreate){

        $this->editionCreate = $editionCreate;
    }

    public function __invoke(ServerRequest $request, Response $response):Response{
        
        $edition = new EditionCreateData($request->getParsedBody());
        
        $insert = $this->editionCreate->createEdition($edition);
        
        //Respuesta 201 create y 400 se debe cambiar peticion antes de repetir
        
        if (!empty($insert['exception'])) {
            return $response->withJson($insert, 400);
        }
        
        return $response->withJson($insert, 201);
    }
}


