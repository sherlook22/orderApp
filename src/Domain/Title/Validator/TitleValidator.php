<?php

namespace App\Domain\Title\Validator;

use Respect\Validation\Exceptions\NestedValidationException;

class TitleValidator{
    
    protected $errors = [];

    public function validate($obj, array $rules):?array{
        
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