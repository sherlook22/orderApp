<?php

namespace App\Action;

use App\Components\JwtAuth;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use App\Domain\User\Data\UserCreateData;
use App\Domain\User\Service\UserLogin;


final class UserValidator
{
    private $jwtAuth;

    private $loginService;

    public function __construct(JwtAuth $jwtAuth, UserLogin $loginService)
    {
        $this->jwtAuth = $jwtAuth;

        $this->loginService = $loginService;
    }

    public function __invoke(ServerRequest $request, Response $response): Response
    {
        $data = (array)$request->getParsedBody();

        $user = new UserCreateData($data);

        $isValidLogin = $this->loginService->validUser($user);
        
        if (!$isValidLogin) {
            // Invalid authentication credentials
            return $response->withJson('Usuario o contraseña incorrectos', 401);
        }

        // Create a fresh token and set the menu
        $token = $this->jwtAuth->createJwt($user->numVendedor);
        $lifetime = $this->jwtAuth->getLifetime();
        $menu = $this->loginService->userMenu($isValidLogin->is_staff);

        // Transform the result into a OAuh 2.0 Access Token Response
        // https://www.oauth.com/oauth2-servers/access-tokens/access-token-response/
        $result = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $lifetime,
            'menu' => $menu,
            'vendedor' => $user->numVendedor
        ]; 

        // Build the HTTP response
        return $response->withJson($result)->withStatus(200);
    }
}