<?php

namespace App\Components;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Auth\JwtAuth;

final class UserDecode{

    private $jwtAuth;

    public function __construct(JwtAuth $jwtAuth){

        $this->jwtAuth = $jwtAuth;

    }
    
    public function getSeller(ServerRequestInterface $request){
        $authorization = explode(' ', (string)$request->getHeaderLine('Authorization'));
        $token = $authorization[1] ?? '';

        $parsedToken = $this->jwtAuth->createParsedToken($token);

        return $parsedToken->getClaim('uid');
    }
}