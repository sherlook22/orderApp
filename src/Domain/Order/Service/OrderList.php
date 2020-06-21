<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Repository\OrderListRepository;


final class OrderList
{
    
    private $repository;


    public function __construct(OrderListRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOrders($args)
    {

        return $this->repository->getOrder($args['vend'], $args['idord']);

    }
}
