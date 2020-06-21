<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Repository\SearchRepository;


final class SearchOrder {

    private $repository;

    public function __construct( SearchRepository $repository )
    {

        $this->repository = $repository;

    }


    public function busca($args)
    {

        if(!is_numeric($args['busca'])) {
            
            $buscaT = $this->repository->byTitle($args['busca'], $args['ed']);
            return !$buscaT->isEmpty() ? $buscaT : [ 'empty' => "Titulo no encontrado" ];  
            
        } else {

            $buscaT = $this->repository->byVendedor($args['busca']);
            return !$buscaT->isEmpty() ? $buscaT : [ 'empty' => "El vendedor no tiene pedidos realizados o no existe" ]; 

        }

    }

}
