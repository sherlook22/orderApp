<?php

namespace App\Domain\Order\Data;

use App\Components\ArrayReader;


final class OrderCreateData{

    public $vendedor;

    public $pedido;

    public function __construct(array $array = []){

        $data = new ArrayReader($array);

        $this->vendedor = $data->findString('vendedor');
        $this->pedido = $data->findArray('pedidos');
    }

}