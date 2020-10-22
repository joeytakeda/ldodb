<?php

namespace App\Repository;

use App\Entity\PlateType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PlateTypeRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, PlateType::class);
    }

    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|PlateType[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.plateType LIKE :q");
        $qb->orderBy('e.plateType');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
