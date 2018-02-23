<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsClientNameUnique extends Constraint
{
    public $message = 'The client name "{{ value }}" is already registered.';
}
