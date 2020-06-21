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
        
        try{
            
            $titleID = $this->connection->table('titles')->insert(
                ['title_name' => $title->title_name]
            );

            return ['title' => $title->title_name];

        } catch(QueryException $e){
            
            if($e->errorInfo[1] == 1062){
                return ['exception' => "El titulo ya existe"];
            }
        }
        

    }
}

