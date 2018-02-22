<?php

namespace App\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Entity\Roles;

class IsRoleSlugUniqueUpdateValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($entity, Constraint $constraint) :void
    {
        /** loading entity repository */
        $repository = $this->em->getRepository(Roles::class);
        $role = $repository->findOneBy(['slug' => $entity->getSlug()]);

        if ($role && $role->getId() !== $entity->getId()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $entity->getSlug())
                ->addViolation();
        }
    }
}
