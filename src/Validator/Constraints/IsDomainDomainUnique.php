<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsDomainDomainUnique extends Constraint
{
    public $message = 'The Domain "{{ value }}" is already registered.';
}
