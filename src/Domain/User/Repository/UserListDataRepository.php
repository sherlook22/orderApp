<?php

namespace App\Domain\User\Repository;

use Illuminate\Database\Connection;

final class UserListDataRepository{

    private $connection;

    public function __construct(Connection $connection){

        $this->connection = $connection;

    }

    public function getAllUsers(){

        return $this->connection->table('users')
                                ->select('numVendedor','nombre','apellido','direccion','email')
                                ->get();
    }

    public function getUser($args){

        return $this->connection->table('users')
                                ->select('numVendedor','nombre','apellido','direccion','email')
                                ->where('numVendedor', $args['vendedor'])
                                ->get();

    }
}