<?php

namespace App\Repository;

use App\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\Pagination\PaginationInterface;

class RolesRepository extends ServiceEntityRepository
{
    /**
     * RolesRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Roles::class);
    }

    /**
     * @param int $page
     * @param Paginator $paginator
     * @throws \LogicException
     * @return PaginationInterface
     */
    public function loadList(int $page, Paginator $paginator) :PaginationInterface
    {
        $em = $this->getEntityManager();
        $dql   = "SELECT r
                    FROM App\Entity\Roles r";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $pagination;
    }
}
