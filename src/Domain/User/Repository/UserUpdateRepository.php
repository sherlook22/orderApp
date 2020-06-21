<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserCreateData;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


class UserUpdateRepository {

    private $connection;

    public function __construct( Connection $connection )
    {
        $this->connection = $connection;
    }

    public function updateUser( UserCreateData $user)
    {

        $update = [

            'nombre' => $user->nombre,
            'apellido' => $user->apellido,
            'direccion' => $user->direccion,
            'telefono' => $user->telefono,
            'email' => $user->email,
            'is_staff' => $user->rol,

        ];

        empty($user->password) ? : $update['password'] = password_hash($user->password, PASSWORD_DEFAULT);

        try{

            $this->connection->table('users')
                             ->where('numVendedor', $user->numVendedor)
                             ->update($update);

            return ['exito' => 'Usuario actualizado'];
        }
        catch(QueryException $e){

            if($e){
                return ['exception' => "Error al actualizar usuario"];
            }
        }
    }

}