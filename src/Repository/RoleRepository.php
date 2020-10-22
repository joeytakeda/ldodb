<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RoleRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Role::class);
    }

    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|Role[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.roleName LIKE :q");
        $qb->orderBy('e.roleName');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
