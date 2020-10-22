<?php

namespace App\Repository;

use App\Entity\BibliographicTerms;
use Doctrine\Common\Collections\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BibliographicTermsRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BibliographicTerms::class);
    }

    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|BibliographicTerms[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.bibliographicTerm LIKE :q");
        $qb->orderBy('e.bibliographicTerm');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
