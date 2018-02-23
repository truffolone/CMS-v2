<?php

namespace App\Validator\Constraints;

use App\Entity\Domain;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsDomainDomainUniqueUpdateValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($entity, Constraint $constraint) :void
    {
        /** loading entity repository */
        $repository = $this->em->getRepository(Domain::class);
        $domain = $repository->findOneBy(['domain' => $entity->getDomain()]);

        if ($domain && $domain->getId() !== $entity->getId()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $entity->getName())
                ->addViolation();
        }
    }
}
