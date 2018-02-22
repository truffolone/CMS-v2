<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsPasswordValidUpdateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint) :void
    {
        if ($value && $value !== '') {
            $uppercase = preg_match('@[A-Z]@', $value);
            $lowercase = preg_match('@[a-z]@', $value);
            $number    = preg_match('@[0-9]@', $value);

            if (!$uppercase || !$lowercase || !$number || \strlen($value) < 8) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $value)
                    ->addViolation();
            }
        }
    }
}
