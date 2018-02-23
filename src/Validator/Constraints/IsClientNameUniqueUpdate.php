<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsClientNameUniqueUpdate extends Constraint
{
    public $message = 'The Client name "{{ value }}" is already registered.';

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
