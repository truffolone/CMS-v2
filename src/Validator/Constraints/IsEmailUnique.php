<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsEmailUnique extends Constraint
{
    public $message = 'The email "{{ value }}" is already registered.';
}
