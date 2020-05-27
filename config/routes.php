<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    
    $app->group('/api', function(RouteCollectorProxy $app){
        
        $app->group('/titles', function(RouteCollectorProxy $app){
            $app->post('/create', \App\Action\TitleCreateAction::class);
            $app->get('/list[/{id}]', \App\Action\TitleListAction::class);
            $app->post('/assigned', \App\Action\TitleAssignEditionAction::class);
            //Para conectar a la api
            $app->options('/create', \App\Action\PreflightAction::class);
        });
        
        $app->group('/edition', function(RouteCollectorProxy $app){
            $app->post('/create', \App\Action\EditionCreateAction::class);
        });
        
        $app->group('/user', function(RouteCollectorProxy $app){
            $app->get('/list[/{vendedor}]', \App\Action\UserListAction::class);
            $app->post('/create', \App\Action\UserCreateAction::class);
            //Para conectar con la api
            $app->options('/create', \App\Action\PreflightAction::class);
        })/* ->add(\App\Middleware\JwtMiddleware::class) */;
        
        $app->group('/order', function(RouteCollectorProxy $app){
            $app->get('/list', \App\Action\OrderListAction::class);
            $app->post('/create', \App\Action\OrderCreateAction::class);
            //Para conectar a la api
            $app->options('/create', \App\Action\PreflightAction::class);
        });
        
        $app->post('/books', \App\Action\HomeAction::class);

        $app->post('/crete', \App\Action\UserCreateAction::class);
    
        $app->post('/token', \App\Action\UserValidator::class)/* ->add(JwtMiddleware::class) */;
        $app->options('/token', \App\Action\PreflightAction::class);
                
    });
};
    
    