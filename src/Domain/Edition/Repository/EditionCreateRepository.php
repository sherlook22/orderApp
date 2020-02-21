<?php

namespace App\Domain\Edition\Repository;

use App\Domain\Edition\Data\EditionCreateData;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


class EditionCreateRepository
{
    
    private $connection;

    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    
    public function insertEdition(EditionCreateData $edition)
    {
        
        try{
            
            $this->connection->table('editions')->insert([
                ['edition_num' => $edition->edicion],
            ]);

            return ['edition_num' => $edition->edicion];

        } catch(QueryException $e){
            
            if($e->errorInfo[1] == 1062){
                return ['exception' => "La edicion ya existe"];
            }
        }
        

    }
}

