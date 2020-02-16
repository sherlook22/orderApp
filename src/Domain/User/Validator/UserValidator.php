<?php

namespace App\Domain\User\Validator;

use App\Domain\User\Data\UserCreateData;
use Respect\Validation\Exceptions\NestedValidationException;

class UserValidator{
    
    protected $errors = [];

    public function validate($obj,  $rules)
    {
        
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