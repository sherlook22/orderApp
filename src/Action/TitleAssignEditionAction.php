<?php

namespace App\Action;

use App\Domain\Title\Data\TitleAssignEditionData;
use App\Domain\Title\Service\TitleAssignEdition;
use Slim\Http\Response;
use Slim\Http\ServerRequest;


final class TitleAssignEditionAction{

    private $titleAssignEdition;

    public function __construct(TitleAssignEdition $titleAssignEdition){

        $this->titleAssignEdition = $titleAssignEdition;
    }

    public function __invoke(ServerRequest $request, Response $response):Response{
        
        $assignament = new TitleAssignEditionData($request->getParsedBody());

        $titleEdition = $this->titleAssignEdition->assign($assignament);
        
        //Respuesta 201 create y 400 se debe cambiar peticion antes de repetir
        
        if (!empty($titleEdition['exception'])) {
            return $response->withJson($titleEdition, 400);
        }
        
        return $response->withJson($titleEdition, 201);
    }
}