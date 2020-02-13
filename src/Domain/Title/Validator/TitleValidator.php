<?php

namespace App\Domain\Title\Validator;

use App\Domain\Title\Data\TitleCreateData;
use Respect\Validation\Exceptions\NestedValidationException;

class TitleValidator{
    
    protected $errors = [];

    public function validate(TitleCreateData $obj, array $rules):?array{
        
        foreach($rules as $field => $rule){
            try{
                $rule->setName(ucfirst($field))->assert($obj->$field);
            }catch(NestedValidationException $e){
                $this->errors[$field] = $e->getMessages() ;
            }
        }

        return $this->errors;
    }
};