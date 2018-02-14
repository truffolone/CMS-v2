<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsPasswordValid extends Constraint
{
    public $message = 'The password needs at least one uppercase character, one lowercase character and one number';
}
