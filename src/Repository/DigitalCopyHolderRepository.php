<?php

namespace App\Repository;

use App\Entity\DigitalCopyHolder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DigitalCopyHolderRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, DigitalCopyHolder::class);
    }
    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|DigitalCopyHolder[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.organizationName LIKE :q");
        $qb->orderBy('e.organizationName');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
