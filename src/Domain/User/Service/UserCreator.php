<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserCreateData;
use App\Domain\User\Repository\UserCreatorRepository;
use App\Domain\User\Validator\UserValidator;
use Respect\Validation\Validator as v;


final class UserCreator
{

    private $repository;

    private $userValidator;
    
    public function __construct(UserValidator $userValidator, UserCreatorRepository $repository)
    {
        $this->repository = $repository;
        $this->userValidator = $userValidator;
    }
    
    public function createUser(UserCreateData $user)
    {
        $validation = $this->userValidator->validate($user,[ 
            'numVendedor' => v::notBlank()->intType()->positive(), 
            'password' => v::notBlank()->noWhitespace(),
            'nombre' => v::optional(v::alpha()),
            'apellido' => v::optional(v::alpha()),
            'direccion' => v::optional(v::stringType()),
            'telefono' => v::optional(v::intType()->positive()),
            'email' => v::optional(v::email()), 
        ]);
        
        return empty($validation) ? $this->repository->insertUser($user) : $validation;
    }
}
