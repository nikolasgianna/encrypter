<?php namespace App\Providers;

use Illuminate\Validation\Validator;

class MyValidator
{
    public function validateEmptyWith($attribute, $value, $parameters, Validator $validator)
    {
        $all_form_data = $validator->getData();
        if (isset($all_form_data[$parameters[0]])) {
            // return false;//($value != null && $all_form_data[$parameters[0]] != null);
            return ($value != null && $all_form_data[$parameters[0]] != null) ? false : true;
        } else {
            return true;
        }
    }
}
