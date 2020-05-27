<?php

namespace App\Domain\Order\Repository;

use App\Domain\Order\Data\OrderCreateData;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


final class OrderCreateRepository{

    private $connection;

    public function __construct(Connection $connection){

        $this->connection = $connection;
    }

    public function insertOrder(OrderCreateData $data){

        try {
            $idUser = $this->connection->table('users')
                                   ->where('numVendedor', $data->vendedor)
                                   ->select('id')
                                   ->first();

            $idPedido = $this->connection->table('orders')
                                     ->insertGetId(
                                         [
                                         'users_id' => $idUser->id
                                        ]
                                     );

            for ($i = 0; $i < count($data->pedido); $i++) {
                $this->connection->table('orders_titles')
                             ->insert([
                                 'orders_id' => $idPedido,
                                 'titles_id' => $data->pedido[$i]['titulo'],
                                 'edition' => $data->pedido[$i]['edicion'],
                                 'cant_pedida'=> $data->pedido[$i]['cantidad']
                             ]);
            }
        }catch(QueryException $e) {
            
            if($e){

                $idPedido = $this->connection->table('orders')
                                             ->where('id', $idPedido)
                                             ->delete();
                                             
                $this->connection->table('orders_titles')
                                 ->where('orders_id', $idPedido)
                                 ->delete();

                return ['exception' => "Error al generar pedido"];
            }
        }

        return ['success' => 'Pedido creado satisfactoriamente'];
    }
}
