<?php

namespace App\Domain\Order\Repository;

use Illuminate\Database\Connection;


final class OrderListRepository{

    private $connection;

    private $pedidos = [];


    public function __construct(Connection $connection)
    {

        $this->connection = $connection;

    }

    public function getOrder($vend, $orderID)
    {
        $userId = $this->connection->table('users')
                                   ->select('id')  
                                   ->where('numVendedor', $vend)
                                   ->first();

                         
        $orders = $this->connection->table('orders')
                                   ->join('orders_titles', 'orders.id', '=', 'orders_titles.orders_id')
                                   ->join('titles', 'orders_titles.titles_id', '=', 'titles.id')      
                                   ->join('editions', 'orders_titles.edition', '=', 'editions.id')
                                   ->select('orders.id', 'orders.order_date','orders.status','titles.title_name', 'edition_num', 
                                     'orders_titles.cant_pedida', 'orders_titles.cant_recibida',
                                     'orders_titles.recepcion', 'orders_titles.estado', 'orders_titles.titles_id', 'orders_titles.edition'
                                    )
                                   ->where('orders.users_id', $userId->id)
                                   ->when($orderID, function($query, $orderID) {
                                    return $query->where('orders.id', $orderID);
                                    })
                                   ->get()
                                   ->groupBy('id');

        
        foreach ($orders/* ->skip($args['page'])->take(3) */ as $value) {
            array_push($this->pedidos, $value);
        }
                                           
                                   
        //$pedidos = $this->pedidos->skip(1)->take($orders->count());    
        
        
        return ['cantidad'=> $orders->count(), 'pedidos' => $this->pedidos];                                                         

    }
}
