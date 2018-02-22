<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsRoleNameUnique extends Constraint
{
    public $message = 'The role name "{{ value }}" is already registered.';
}
