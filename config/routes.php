<?php

use Slim\App;
use App\Models\User;


return function (App $app) {
    $app->post('/', \App\Action\TitleCreateAction::class);
    
    $app->post('/crete', \App\Action\UserCreateAction::class);
    
    $app->post('/api/tokens', \App\Action\TokenCreateAction::class);

    $app->get('/orders', \App\Action\OrderGetAllAcction::class);

    $app->get('/books', \App\Action\HomeAction::class);
};