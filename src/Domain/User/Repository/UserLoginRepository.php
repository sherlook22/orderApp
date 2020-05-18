<?php

namespace App\Domain\User\Repository;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


class UserLoginRepository
{
    
    private $connection;

    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    
    public function usuarioValido($user)
    {
        
        $validUser = $this->connection->table('users')
                            ->where('numVendedor',$user)
                            ->first();
        return $validUser;
        
    }

    public function roleMenu($role){
        
        if ($role == '0') {

            return $menu = $this->connection->table('menu')
                                ->select('nombre', 'url')
                                ->where('role', $role)
                                ->get();

        } elseif($role == '1') {
            return $menu = $this->connection->table('menu')
                                ->select('nombre', 'url')
                                ->get();
        }else{
            return;
        }
    }

}

