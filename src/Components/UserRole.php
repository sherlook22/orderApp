<?php

namespace App\Components;

use Illuminate\Database\Connection;

final class UserRole{

    private $connection;

    public function __construct( Connection $connection )
    {

        $this->connection = $connection;

    }

    public function getRole( $vendedor )
    {

        return $role = $this->connection->table('users')
                                        ->where('numVendedor', $vendedor)
                                        ->select('id','is_staff')
                                        ->first();                                

    }
    
}