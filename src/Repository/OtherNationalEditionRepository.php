<?php

namespace App\Repository;

use App\Entity\OtherNationalEdition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OtherNationalEditionRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, OtherNationalEdition::class);
    }

}
