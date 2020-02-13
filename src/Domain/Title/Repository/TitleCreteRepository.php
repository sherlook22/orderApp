<?php

namespace App\Domain\Title\Repository;

use App\Domain\Title\Data\TitleCreateData;
use Illuminate\Database\Connection;
//use Illuminate\Database\QueryException;


class TitleCreateRepository
{
    
    private $connection;

    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    
    public function insertTitle(TitleCreateData $title): string
    {
        $values = [
            'title_name' => $title->title_name
        ];

        $this->connection->table('titles')->insert($values);

        return (string)$title->title_name;
    }
}

