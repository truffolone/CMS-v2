<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\Pagination\PaginationInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $email
     * @param string $username
     * @return null|User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByEmailOrUsername(string $email, string $username): ?User
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.email = :email OR u.username = :username')
            ->setParameter('email', $email)
            ->setParameter('username', $username)
            ->getQuery();

        return $qb->setMaxResults(1)->getOneOrNullResult();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
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
        $dql   = "SELECT u
                    FROM App\Entity\User u
                    LEFT JOIN u.userInfo i";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $pagination;
    }
}
