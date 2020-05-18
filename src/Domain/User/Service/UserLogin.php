<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserCreateData;
use App\Domain\User\Repository\UserLoginRepository;


final class UserLogin
{

    private $repository;
    
    public function __construct(UserLoginRepository $repository)
    {
        $this->repository = $repository;
    }


    public function validUser(UserCreateData $user){
        $vend = $this->repository->usuarioValido($user->numVendedor);
    
        if(empty($vend)){
            return false;
        }elseif(password_verify($user->password,$vend->password)){
            return $vend;
        }else{
            return false;
        }
    
    }    

    public function userMenu($role){

        return $this->repository->roleMenu($role);
    }
   
}
