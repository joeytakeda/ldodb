<?php

namespace App\Repository;

use App\Entity\People;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PeopleRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, People::class);
    }

    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|People[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("CONCAT_WS(' ', e.lastName, e.firstName) LIKE :q");
        $qb->orderBy('e.lastName');
        $qb->orderBy('e.firstName');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

    /**
     * Prepare a search query, but do not execute it.
     *
     * @param string $q
     * @return Collection|People[]
     */
    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->addSelect("MATCH (e.firstName, e.lastName) AGAINST(:q BOOLEAN) as HIDDEN score");
        $qb->andWhere("MATCH (e.firstName, e.lastName) AGAINST(:q BOOLEAN) > 0.0");
        $qb->orderBy('score', 'DESC');
        $qb->setParameter('q', $q);
        return $qb->getQuery();
    }

}
