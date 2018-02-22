<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsRoleSlugUnique extends Constraint
{
    public $message = 'The role slug "{{ value }}" is already registered.';
}
