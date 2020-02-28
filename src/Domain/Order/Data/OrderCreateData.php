<?php

namespace App\Domain\Order\Data;

use App\Components\ArrayReader;


final class OrderCreateData{

    //Array
    public $pedido;

    public function __construct(array $array = []){

        $data = new ArrayReader($array);

        $this->pedido = $data->findArray('pedido');
    }

}