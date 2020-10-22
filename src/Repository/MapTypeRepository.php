<?php

namespace App\Repository;

use App\Entity\MapType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MapTypeRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, MapType::class);
    }

    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|MapType[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.mapType LIKE :q");
        $qb->orderBy('e.mapType');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
