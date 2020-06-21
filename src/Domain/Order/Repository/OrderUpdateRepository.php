<?php

namespace App\Domain\Order\Repository;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


class OrderUpdateRepository
{

    private $connection;

    public function __construct( Connection $connection )
    {

        $this->connection = $connection;

    }


    public function update($pedidos)
    {

        foreach ($pedidos['pedido'] as $key => $value) {
            
            
            $titulo = $this->connection->table('orders_titles')
                            ->where([
                            ['orders_id','=',$value['idorder']],
                            ['titles_id','=',$value['titulo']],
                            ['edition','=',$value['edicion']],
                            ])->first();
            
            if( $titulo->cant_pedida != $value['cantRec']) {
                $this->connection->table('orders_titles')
                            ->where([
                            ['orders_id','=',$value['idorder']],
                            ['titles_id','=',$value['titulo']],
                            ['edition','=',$value['edicion']],
                            ])
                            ->update([
                                'cant_recibida' => $value['cantRec'],
                                'recepcion' => NULL,
                                'estado' => 'Pendiente'
                            ]);
            }

            if( $titulo->cant_pedida == $value['cantRec'] ) {
                $this->connection->table('orders_titles')
                            ->where([
                            ['orders_id','=',$value['idorder']],
                            ['titles_id','=',$value['titulo']],
                            ['edition','=',$value['edicion']],
                            ])
                            ->update([
                                'cant_recibida' => $value['cantRec'],
                                'estado' => "Recibido",
                                'recepcion' => date("Y-m-d")                                
                            ]);
            }

        }

        $estado =  $this->connection->table('orders AS O')
                                    ->leftJoin('orders_titles AS OT', 'O.id','=','OT.orders_id')
                                    ->where('O.id',$pedidos['pedido'][0]['idorder'])
                                    ->select('OT.estado')
                                    ->get();
        $count = 0;
        foreach ($estado as $value) {
            if($value->estado == 'Pendiente') {
            break;
            }
            else {
                $count++;
            }
        }

        $estado->count() == $count ? $this->pedidoCompletado($pedidos['pedido'][0]['idorder']) : 
                                     $this->pedidoIncompleto($pedidos['pedido'][0]['idorder']);

    }

    public function pedidoCompletado($id) {
        $this->connection->table('orders')
                         ->where('id',$id)
                         ->update(['status' => 'Completado']);
    }
    
    public function pedidoIncompleto($id) {
        $this->connection->table('orders')
                         ->where('id',$id)
                         ->update(['status' => 'Pendiente']);
    }

}

