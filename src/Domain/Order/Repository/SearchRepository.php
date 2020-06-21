<?php

namespace App\Domain\Order\Repository;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;


class SearchRepository {

    private $connection;

    public function __construct( Connection $connection )
    {

        $this->connection = $connection;

    }


    public function byTitle( $title, $ed )
    {
        
        try{
            $idPedidos =  $this->connection->table('orders_titles AS OT')
                            ->leftJoin('titles AS T', 'T.id','=','OT.titles_id')
                            ->leftJoin('editions AS E','E.id','=','OT.edition')
                            ->leftJoin('orders AS O','O.id','=','OT.orders_id')
                            ->Join('users AS U', 'U.id', '=', 'O.users_id')
                            ->when($title, function($query, $title) {
                                return $query->where('T.title_name','like','%'.$title.'%');
                            })
                            ->when($ed, function($query, $ed) {
                                return $query->where('E.edition_num', $ed);
                            })
                            ->select(
                                'OT.orders_id','OT.cant_pedida','OT.cant_recibida','OT.recepcion',
                                'OT.estado','T.title_name','E.edition_num','O.order_date','O.status',
                                'U.numVendedor'
                            )
                            ->get();
            
            if (!empty($title)) {
                $id = [];

                foreach ($idPedidos as $key => $value) {
                    array_push($id, $value->orders_id);
                }

                return $this->connection->table('orders_titles AS OT')
                            ->leftJoin('titles AS T', 'T.id', '=', 'OT.titles_id')
                            ->leftJoin('editions AS E', 'E.id', '=', 'OT.edition')
                            ->leftJoin('orders AS O', 'O.id', '=', 'OT.orders_id')
                            ->Join('users AS U', 'U.id', '=', 'O.users_id')
                            ->whereIn('OT.orders_id', $id)
                            ->select(
                                'OT.orders_id',
                                'OT.cant_pedida',
                                'OT.cant_recibida',
                                'OT.recepcion',
                                'OT.estado',
                                'T.title_name',
                                'E.edition_num',
                                'O.order_date',
                                'O.status',
                                'U.numVendedor'
                            )
                            ->get()
                            ->groupBy('orders_id'); 
        } else {

            return $idPedidos->groupBy('orders_id');
        }

    }catch(QueryException $e) {
        return ['exception' => 'Error al realizar la busqueda'];
    }
        
    }

    public function byVendedor( $vend )
    {

        try {
            return $this->connection->table('orders_titles AS OT')
                            ->leftJoin('titles AS T', 'T.id', '=', 'OT.titles_id')
                            ->leftJoin('editions AS E', 'E.id', '=', 'OT.edition')
                            ->leftJoin('orders AS O', 'O.id', '=', 'OT.orders_id')
                            ->Join('users AS U', 'U.id', '=', 'O.users_id')
                            ->where('U.numVendedor', $vend)
                            ->select(
                                'OT.orders_id',
                                'OT.cant_pedida',
                                'OT.cant_recibida',
                                'OT.recepcion',
                                'OT.estado',
                                'T.title_name',
                                'E.edition_num',
                                'O.order_date',
                                'O.status',
                                'U.numVendedor'
                            )
                            ->get()
                            ->groupBy('orders_id');
        }catch(QueryException $e) {
            return ['exception' => 'Error al realizar la busqueda'];
        }
    }

}