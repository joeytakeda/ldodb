<?php

namespace App\Repository;

use App\Entity\BindingFeature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BindingFeatureRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BindingFeature::class);
    }
    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|BindingFeature[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.bindingFeature LIKE :q");
        $qb->orderBy('e.bindingFeature');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
