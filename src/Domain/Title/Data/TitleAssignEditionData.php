<?php

namespace App\Domain\Title\Data;

use App\Components\ArrayReader;

final class TitleAssignEditionData{

    public $titleID;

    public $editionID;

    public function __construct(array $array = []){

        $data = new ArrayReader($array);

        $this->titleID = $data->findInt('title_id');
        $this->editionID = $data->findInt('edition_id');
    }
}