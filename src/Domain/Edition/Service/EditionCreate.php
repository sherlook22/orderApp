<?php

namespace App\Domain\Edition\Service;

use App\Domain\Edition\Data\EditionCreateData;
use App\Domain\Edition\Repository\EditionCreateRepository;
use App\Components\Validator;
use Respect\Validation\Validator as v;

final class EditionCreate{

    protected $validator;

    protected $repository;

    public function __construct(Validator $validator, EditionCreateRepository $repository){

        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function createEdition(EditionCreateData $edition){

        $validation = $this->validator->validate($edition, [
            'edicion' => v::notBlank()->intType()->positive(),
        ]);

        if ($validation) {
            return $validation;
        }

        $edition = $this->repository->insertEdition($edition);

        return $edition;

    }

}