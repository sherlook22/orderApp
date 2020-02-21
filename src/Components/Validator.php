<?php

namespace App\Components;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator{
    
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