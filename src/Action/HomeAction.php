<?php

namespace App\Action;

use Illuminate\Database\Connection;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

final class HomeAction
{
    private $connection;

    public function __construct(Connection $connection){
        $this->connection = $connection;
    }


    public function __invoke(ServerRequest $request, Response $response): Response
    {
        $user = $this->connection->table('users')->get();
        
        return $response->withJson(['success' => $user->toArray()]);
    }
}