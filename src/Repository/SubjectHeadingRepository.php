<?php

namespace App\Repository;

use App\Entity\SubjectHeading;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SubjectHeadingRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, SubjectHeading::class);
    }

    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|SubjectHeading[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.subjectHeadingName LIKE :q");
        $qb->orderBy('e.name');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

    /**
     * Prepare a search query, but do not execute it.
     *
     * @param string $q
     * @return Collection|SubjectHeading[]
     */
    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->addSelect("MATCH (e.subjectHeadingName) AGAINST(:q BOOLEAN) as HIDDEN score");
        $qb->addSelect("MATCH (e.subjectHeadingName) AGAINST(:q BOOLEAN) > 0.0");
        $qb->orderBy('score', 'DESC');
        $qb->setParameter('q', $q);
        return $qb->getQuery();
    }

}
