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

            $menu = $this->connection->table('menu')
                                ->join('submenu', 'submenu.id_menu', '=', 'menu.id')
                                ->where('rol', $role)
                                ->select('menu.grupo', 'submenu.nombre', 'submenu.url')
                                ->get()
                                ->groupBy('grupo');
                                
            return $menu;
     


        } elseif($role == '1') {
            $menu = $this->connection->table('menu')
                                ->join('submenu', 'submenu.id_menu', '=', 'menu.id')
                                ->where('rol', $role)
                                ->select('menu.grupo', 'submenu.nombre', 'submenu.url')
                                ->get()
                                ->groupBy('grupo');

            return $menu;                                
                                            
        }else{
            return;
        }
    }

}

