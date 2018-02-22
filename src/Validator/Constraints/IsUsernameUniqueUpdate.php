<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsUsernameUniqueUpdate extends Constraint
{
    public $message = 'The username "{{ value }}" is already taken.';

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
