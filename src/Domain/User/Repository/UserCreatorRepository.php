<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserCreateData;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


class UserCreatorRepository
{
    
    private $connection;

    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    
    public function insertUser(UserCreateData $user)
    {
        $values = [
            'numVendedor' => $user->numVendedor,
            'password' => password_hash($user->password, PASSWORD_DEFAULT),
            'nombre' => $user->nombre,
            'apellido' => $user->apellido,
            'direccion' => $user->direccion,
            'telefono' => $user->telefono,
            'email' => $user->email,
            'is_staff' => $user->rol,
        ];

        try{
            $id = $this->connection->table('users')->insertGetId($values);
            return $id;

        }catch(QueryException $e){

            if($e->errorInfo[1] == 1062){
                return ['exception' => "El usuario '$user->numVendedor' ya existe"];
            }
        }
        
    }
}

