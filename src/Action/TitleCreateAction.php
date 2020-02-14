<?php

namespace App\Action;

use App\Domain\Title\Data\TitleCreateData;
use App\Domain\Title\Service\TitleCreate;
use Slim\Http\Response;
use Slim\Http\ServerRequest;


final class TitleCreateAction{

    private $titleCreate;

    public function __construct(TitleCreate $titleCreate){

        $this->titleCreate = $titleCreate;
    }

    public function __invoke(ServerRequest $request, Response $response):Response{
        
        $data = $request->getParsedBody();
        
        $title = new TitleCreateData($request->getParsedBody());
        
        $insert = $this->titleCreate->createTitle($title);
        
        return $response->withJson($insert);
    }
}