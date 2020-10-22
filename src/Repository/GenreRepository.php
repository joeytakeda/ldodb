<?php

namespace App\Repository;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GenreRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Genre::class);
    }
    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|Genre[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.genreName LIKE :q");
        $qb->orderBy('e.genreName');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
