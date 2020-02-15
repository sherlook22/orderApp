<?php

namespace App\Domain\Title\Service;

use App\Domain\Title\Repository\TitleListRepository;

final class TitleListData{

    protected $repository;

    public function __construct(TitleListRepository $repository){

        $this->repository = $repository;
    }

    public function listTitle(array $args){

        if (!empty($args)) {
            return $this->repository->getTitle($args);
        }

        return $this->repository->getAllTitles();

    }

}