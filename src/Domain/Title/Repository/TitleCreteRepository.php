<?php

namespace App\Domain\Title\Repository;

use App\Domain\Title\Data\TitleCreateData;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


class TitleCreateRepository
{
    
    private $connection;

    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    
    public function insertTitle(TitleCreateData $title)
    {
        $values = [
            'title_name' => $title->title_name
        ];

        try{
            
            $this->connection->table('titles')->insert($values);
            return ['title' => $title->title_name];

        } catch(QueryException $e){
            
            if($e->errorInfo[1] == 1062){
                return ['exception' => "El titulo '$title->title_name' ya existe"];
            }
        }
        

    }
}

