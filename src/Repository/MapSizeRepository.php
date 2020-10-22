<?php

namespace App\Repository;

use App\Entity\MapSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MapSizeRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, MapSize::class);
    }
    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|MapSize[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.mapSize LIKE :q");
        $qb->orderBy('e.mapSize');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
