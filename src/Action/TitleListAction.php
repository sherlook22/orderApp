<?php

namespace App\Action;

use App\Domain\Title\Service\TitleListData;
use Slim\Http\Response;
use Slim\Http\ServerRequest;


final class TitleListAction{

    private $titleListData;

    public function __construct(TitleListData $titleListData){

        $this->titleListData = $titleListData;
    } 

    public function __invoke(ServerRequest $request, Response $response, array $args):Response{
        
        $titles = $this->titleListData->listTitle($args);
        
        return $response->withJson($titles, 200);
        
    }
        
}