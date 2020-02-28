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

    public function insertOrder($user, OrderCreateData $data){

        try {
            $idUser = $this->connection->table('users')
                                   ->where('numVendedor', $user)
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
                                 'titles_id' => $data->pedido[$i]['id'],
                                 'edition' => $data->pedido[$i]['edicion'],
                                 'cant_pedida'=> $data->pedido[$i]['cantidad']
                             ]);
            }
        }catch(QueryException $e) {
            
            if($e->errorInfo[1] == 1062){
                return ['exception' => "Titulo duplicado en el pedido"];
            }
        }

        return ['success' => 'Pedido creado satisfactoriamente'];
    }
}
