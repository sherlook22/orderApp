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
                   
            return $this->connection->table('editions_titles')
                                    ->join('titles','editions_titles.titles_id','=','titles.id')
                                    ->join('editions','editions_titles.editions_id','=','editions.id')
                                    ->select('title_name','edition_num', 'editions.id')
                                    ->where('titles.id', $args['id'])
                                    ->get();
        
    }

    public function getAllTitles(){
        return $this->connection->table('titles')
                                ->select('title_name', 'id')
                                ->get();
    }

}

