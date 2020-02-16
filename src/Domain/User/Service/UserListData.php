<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserListDataRepository;

final class UserListData{

    private $repository;

    public function __construct(UserListDataRepository $repository){
        
        $this->repository = $repository;

    }

    public function listUser($args){

        return empty($args) ? $this->repository->getAllUsers():
                              $this->repository->getUser($args);  
    }
}