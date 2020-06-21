<?php

namespace App\Domain\User\Data;

use App\Components\ArrayReader;

final class UserCreateData
{
    //Integer
    public $numVendedor;
    //String
    public $password;
    //String
    public $nombre;
    //String
    public $apellido;
    //String
    public $direccion;
    //Integer
    public $telefono;
    //String
    public $email;
    //Int
    public $rol;
    
    public function __construct(array $array = []){

        $data = new ArrayReader($array);

        $this->numVendedor = $data->findInt('numVendedor');
        $this->password = $data->findString('password');
        $this->nombre = $data->findString('nombre');
        $this->apellido = $data->findString('apellido');
        $this->direccion = $data->findString('direccion');
        $this->telefono = $data->findInt('telefono');
        $this->email = $data->findString('email');
        $this->rol = $data->findString('rol');
    }

}
