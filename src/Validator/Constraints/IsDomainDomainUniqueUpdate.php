<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsDomainDomainUniqueUpdate extends Constraint
{
    public $message = 'The domain "{{ value }}" is already registered.';

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
