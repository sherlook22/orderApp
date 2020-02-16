<?php

namespace App\Domain\User\Repository;

use Illuminate\Database\Connection;

final class UserListDataRepository{

    private $connection;

    public function __construct(Connection $connection){

        $this->connection = $connection;

    }

    public function getAllUsers(){

        return $this->connection->table('users')->select('*')->get();
    }

    public function getUser($args){

        return $this->connection->table('users')->where('numVendedor','LIKE', '%'.$args['vendedor'].'%')
                                                ->orwhere('nombre','LIKE', '%'.$args['vendedor'].'%')
                                                ->orwhere('apellido','LIKE', '%'.$args['vendedor'].'%')
                                                ->get();

    }
}