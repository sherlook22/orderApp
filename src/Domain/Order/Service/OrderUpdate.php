<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Repository\OrderUpdateRepository;


final class OrderUpdate
{
    private $repository;

    public function __construct(OrderUpdateRepository $repository)
    {

        $this->repository = $repository;

    }


    public function recepcion($pedidos)
    {
        
        return $this->repository->update($pedidos);

    }


}

