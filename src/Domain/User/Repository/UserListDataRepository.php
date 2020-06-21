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
                                ->select('numVendedor','nombre','apellido','direccion','telefono','email')
                                ->orderBy('numVendedor')
                                ->get();
    }

    public function getUser($args){

        return $this->connection->table('users')
                                ->select('numVendedor','nombre','apellido','direccion','email','is_staff','telefono')
                                ->where('numVendedor', $args['vendedor'])
                                ->get();

    }
}