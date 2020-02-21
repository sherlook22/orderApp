<?php

namespace App\Domain\Edition\Data;

use App\Components\ArrayReader;

final class EditionCreateData
{
    //Integer
    public $edicion;

    public function __construct(array $array = []){

        $data = new ArrayReader($array);

        $this->edicion = $data->findInt('edicion');
    }

}