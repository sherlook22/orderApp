<?php

namespace App\Domain\Title\Service;

use App\Domain\Title\Data\TitleCreateData;
use App\Domain\Title\Repository\TitleCreateRepository;
use App\Domain\Title\Validator\TitleValidator;
use Respect\Validation\Validator as v;

final class TitleCreate{

    protected $titleValidator;

    protected $repository;

    public function __construct(TitleValidator $titleValidator, TitleCreateRepository $repository){

        $this->titleValidator = $titleValidator;
        $this->repository = $repository;
    }

    public function createTitle(TitleCreateData $title){

        $validation = $this->titleValidator->validate($title, [
            'title_name' => v::notBlank()->stringType(),
            'edicion' => v::notBlank()->intType()->positive(),
        ]);

        if ($validation) {
            return $validation;
        }

        $titleName = $this->repository->insertTitle($title);

        return $titleName;

    }

}