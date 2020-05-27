<?php

namespace App\Middleware;

use App\Components\JwtAuth;
use App\Components\UserRole;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


final class AuthRoleMiddleware implements MiddlewareInterface
{
    
    private $jwtAuth;

    private $userRole;

    private $responseFactory;

    public function __construct(JwtAuth $jwtAuth, 
                                ResponseFactoryInterface $responseFactory,
                                UserRole $userRole
    )
    {
        $this->jwtAuth = $jwtAuth;
        $this->userRole = $userRole;
        $this->responseFactory = $responseFactory;
    }

    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorization = explode(' ', (string)$request->getHeaderLine('Authorization'));
        $token = $authorization[1] ?? '';

        if (!$token || !$this->jwtAuth->validateToken($token)) {
            return $this->responseFactory->createResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401, 'Unauthorized');
        }

        // Append valid token
        $parsedToken = $this->jwtAuth->createParsedToken($token);
        $request = $request->withAttribute('token', $parsedToken);

        //Get user by the token
        $user = $parsedToken->getClaim('uid');


        if( $this->userRole->getRole($user)->is_staff == 1)
        {
            // Append the user id as request attribute
            $request = $request->withAttribute('uid', $user);

            return $handler->handle($request);
    
        }

        return $this->responseFactory->createResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401, 'Unauthorized');

    }
}