<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class);

    $app->post('/api/tokens', \App\Action\TokenCreateAction::class);

    $app->get('/orders', \App\Action\OrderGetAllAcction::class);

    $app->get('/books', function ($request, $response) {
        //return var_dump(getenv('PRIVATE_KEY'));
    });
};