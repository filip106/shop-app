<?php


namespace src\Validator;


class CategoryValidator extends BaseValidator
{

    /**
     * Add rules to validator.
     * Usage: $this->validator->rule('required', 'name');
     *
     * @return void
     */
    protected function addRules()
    {
        $this->validator->rule('required', 'name');
        $this->validator->rule('lengthMin', 'name', 4);
        $this->validator->rule('lengthMax', 'name', 60);
    }
}