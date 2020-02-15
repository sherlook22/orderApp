<?php

namespace App\Domain\Title\Repository;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


class TitleListRepository
{
    
    private $connection;

    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    
    public function getTitle(array $args){
                   
            return $this->connection->table('titles')
                                    ->where('title_name','LIKE', '%' . $args['slug'] . '%' )
                                    ->get();
        
    }

    public function getAllTitles(){
        return $this->connection->table('titles')->select('*')->get();
    }

}

