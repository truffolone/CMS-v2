<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsContractTypeNameUnique extends Constraint
{
    public $message = 'The Contract Type with name "{{ value }}" is already registered.';
}
