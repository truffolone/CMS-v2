<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;

class GroupRepository extends ServiceEntityRepository
{
    /**
     * Array which stores the compiled values of the object to enter in the database
     * @var array $compiledArray
     */
    private $compiledArray = [];

    /**
     * Stores all the permission field list to create automation
     * @var array $permissionFieldList
     */
    private static $permissionFieldList = [
        'sutterAcademy',
        'editSutter',
        'prodotti',
        'wizard',
        'piani'
    ];

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Group::class);
    }

    /**
     * @param array $permissions
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findByPermissions(array $permissions = [])
    {
        $return = $this->createQueryBuilder('g');

        if (\count($permissions) > 0) {
            foreach ($permissions as $key => $value) {
                $return->where('g.' . $key . ' = :value')->setParameter('value', $value);
            }
        }

        return $return->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }

    /**
     * @param array $groupArray
     * @return mixed
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws ORMInvalidArgumentException
     */
    public function fromPermissionsFacade(array $groupArray = [])
    {
        if (\count($groupArray) === 0
            || (\array_key_exists('name', $groupArray)
                && \trim($groupArray['name']) !== '')) {
            /** array empty or just name defined and forcing creation of new group */
            $this->compile($groupArray);
        } else {
            /** trying to find a group with the permissions defined */
            $permissions = [];
            foreach (self::$permissionFieldList as $permission) {
                $permissions[$permission] = \array_key_exists($permission, $groupArray) ?
                    $groupArray[$permission] : 0;
            }

            if ($foundGroup = $this->findByPermissions($permissions)) {
                /** we found the group, we return it */
                return $foundGroup;
            }

            /** otherwise we create a new group */
            $this->compile($groupArray);
        }

        /** we create the compiled new group */
        return $this->create();
    }

    /**
     * @param array $group
     * @return void
     */
    public function compile(array $group = []) :void
    {
        $compiledArray = [];

        /** Name */
        $compiledArray['name'] = (\array_key_exists('name', $group) && trim($group['name']) !== '') ?
            $group['name'] : uniqid('group_', true);

        /** permissions */
        foreach (self::$permissionFieldList as $permission) {
            $compiledArray[$permission] = \array_key_exists($permission, $group) ? $group[$permission] : 0;
        }

        /** saving the array */
        $this->compiledArray = $compiledArray;
    }

    /**
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws ORMInvalidArgumentException
     */
    public function create()
    {
        /** checking if we got empty compiled data */
        if (\count($this->compiledArray) === 0) {
            $this->compile();
        }

        /** loading resources */
        $em = $this->getEntityManager();
        $group = new Group();

        /** binding values */
        $group->setName($this->compiledArray['name']);
        $group->setSutterAcademy($this->compiledArray['sutterAcademy']);
        $group->setEditSutter($this->compiledArray['editSutter']);
        $group->setProdotti($this->compiledArray['prodotti']);
        $group->setWizard($this->compiledArray['wizard']);
        $group->setPiani($this->compiledArray['piani']);

        /** saving object */
        $em->persist($group);
        $em->flush();

        /** returning object */
        return $group;
    }
}
