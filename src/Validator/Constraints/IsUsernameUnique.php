<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsUsernameUnique extends Constraint
{
    public $message = 'The username "{{ value }}" is already taken.';
}
