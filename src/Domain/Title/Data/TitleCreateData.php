<?php

namespace App\Domain\Title\Data;

use App\Components\ArrayReader;

final class TitleCreateData
{
    //String
    public $title_name;
    //Integer
    public $edicion;

    public function __construct(array $array = []){

        $data = new ArrayReader($array);

        $this->title_name = $data->findString('title_name');
        $this->edicion = $data->findInt('edicion');
    }

}
