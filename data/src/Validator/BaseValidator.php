<?php

namespace src\Validator;

use Valitron\Validator;

abstract class BaseValidator
{
    /** @var Validator */
    protected $validator;

    public final function validate($data)
    {
        $this->validator = new Validator($data);
        $this->addRules();

        if ($this->validator->validate()) {
            return true;
        }

        return $this->validator->errors();
    }

    /**
     * Add rules to validator.
     * Usage: $this->validator->rule('required', 'name');
     *
     * @return void
     */
    protected abstract function addRules();
}