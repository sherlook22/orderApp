<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;


return function (App $app) {
    
    $app->group('/api', function(RouteCollectorProxy $app){
        
        $app->group('/titles', function(RouteCollectorProxy $app){
            $app->get('/list[/{slug}]', \App\Action\TitleListAction::class);
            $app->post('/createtitle', \App\Action\TitleCreateAction::class);
        });
        
        $app->get('/books', \App\Action\HomeAction::class);

        $app->post('/crete', \App\Action\UserCreateAction::class);
    
        $app->post('tokens', \App\Action\TokenCreateAction::class);

        $app->get('/orders', \App\Action\OrderGetAllAcction::class);

        
    });
};
    
    