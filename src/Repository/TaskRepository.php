<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Task::class);
    }

    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|Task[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.taskName LIKE :q");
        $qb->orderBy('e.taskName');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

}
