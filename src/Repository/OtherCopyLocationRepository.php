<?php

namespace App\Repository;

use App\Entity\OtherCopyLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OtherCopyLocationRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, OtherCopyLocation::class);
    }

}
