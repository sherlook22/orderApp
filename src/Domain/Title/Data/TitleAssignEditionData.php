<?php

namespace App\Domain\Title\Data;

use App\Components\ArrayReader;

final class TitleAssignEditionData{

    public $titleID;

    public $numEd;

    public function __construct(array $array = []){

        $data = new ArrayReader($array);

        $this->titleID = $data->findInt('title_id');
        $this->numEd = $data->findInt('num_ed');
    }
}