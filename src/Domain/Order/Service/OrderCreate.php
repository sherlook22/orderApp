<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Data\OrderCreateData;
use App\Domain\Order\Repository\OrderCreateRepository;


final class OrderCreate{

    private $repository;

    public function __construct(OrderCreateRepository $repository){

        $this->repository = $repository;
    }

    public function createOrder(OrderCreateData $data){
        
        return $this->repository->insertOrder($data);

    }
}