<?php

namespace App\Domain\Title\Service;

use App\Domain\Title\Data\TitleAssignEditionData;
use App\Domain\Title\Repository\TitleAssignEditionRepository;
use App\Components\Validator;
use Respect\Validation\Validator as v;

final class TitleAssignEdition{

    private $repository;

    private $validator;

    public function __construct(TitleAssignEditionRepository $repository, Validator $validator){

        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function assign(TitleAssignEditionData $assignament){

        $validation = $this->validator->validate($assignament, [
            'titleID' => v::notBlank()->intType()->positive(),
            'numEd' => v::notBlank()->intType()->positive(),
        ]);

        return $validation ? $validation : $this->repository->addEdition($assignament);

    }

}
