<?php

namespace App\Domain\Order\Repository;

use App\Domain\Order\Data\OrderCreateData;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use App\Components\SendPedido;


final class OrderCreateRepository{

    private $connection;

    private $sendPedido;

    public function __construct(Connection $connection, SendPedido $sendPedido){

        $this->connection = $connection;

        $this->sendPedido = $sendPedido;
    }

    public function insertOrder(OrderCreateData $data){

        try {
            $idUser = $this->connection->table('users')
                                   ->where('numVendedor', $data->vendedor)
                                   ->select('id','nombre','apellido')
                                   ->first();

            $idPedido = $this->connection->table('orders')
                                     ->insertGetId(
                                         [
                                         'users_id' => $idUser->id
                                        ]
                                     );
            
            $ped = [];

            for ($i = 0; $i < count($data->pedido); $i++) {
                $this->connection->table('orders_titles')
                             ->insert([
                                 'orders_id' => $idPedido,
                                 'titles_id' => $data->pedido[$i]['titulo'],
                                 'edition' => $data->pedido[$i]['edicion'],
                                 'cant_pedida'=> $data->pedido[$i]['cantidad']
                             ]);

                $ped[$i] = $this->connection->table('orders_titles AS OT')
                                 ->leftJoin('titles AS T','T.id','=','OT.titles_id')
                                 ->leftJoin('editions AS E','E.id','=','OT.edition')
                                 ->where([
                                     ['OT.orders_id', $idPedido],
                                     ['OT.titles_id',$data->pedido[$i]['titulo']],
                                     ['OT.edition',$data->pedido[$i]['edicion']]
                                 ])
                                 ->select('T.title_name', 'E.edition_num','OT.cant_pedida')
                                 ->first();
                                
            }
            
            $this->sendPedido->enviar(['vendedor'=> $data->vendedor,'nombre' => $idUser->nombre, 'apellido' => $idUser->apellido,'pedido' => $ped]);

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
