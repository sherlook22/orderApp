<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserCreateData;
use App\Domain\User\Repository\UserUpdateRepository;


final class UserUpdate {

    private $repository;

    public function __construct( UserUpdateRepository $repository )
    {
        $this->repository = $repository;
    }

    public function update( UserCreateData $user ) 
    {
        return $this->repository->updateUser($user);
    }

}