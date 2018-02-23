<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsContractTypeNameUniqueUpdate extends Constraint
{
    public $message = 'The contract type with name "{{ value }}" is already registered.';

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
