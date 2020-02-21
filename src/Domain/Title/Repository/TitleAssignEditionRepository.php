<?php

namespace App\Domain\Title\Repository;

use App\Domain\Title\Data\TitleAssignEditionData;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


final class TitleAssignEditionRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function addEdition(TitleAssignEditionData $assignament)
    {
        try {

            $this->connection->table('editions_titles')->insert(
                ['editions_id' => $assignament->editionID,
                 'titles_id' => $assignament->titleID]
            );

            return ['title' => $assignament->titleID, 'edicion' => $assignament->editionID];

        } catch (QueryException $e) {
            
            if ($e->errorInfo[1] == 1062) {
                return ['exception' => "La edicion ya existe para el titulo"];
            }
        }
    }
}