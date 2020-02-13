<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserCreateData;
use Illuminate\Database\Connection;


class UserCreatorRepository
{
    
    private $connection;

    
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    
    public function insertUser(UserCreateData $user): int
    {
        $row = [
            'email' => $user->email,
            'username' => $user->username,
            'password' => $user->password,
        ];

        $newId = $this->connection->table('users')->insertGetId($values);

        return (int)$newId;
    }
}

