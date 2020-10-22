<?php

namespace App\Repository;

use App\Entity\Entity;
use App\Entity\Organization;
use App\Entity\People;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository as BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class EntityRepository extends BaseRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Entity::class);
    }

    /**
     * Prepare a type-ahead query and execute it.
     *
     * @param string $q
     * @return Collection|Entity[]
     */
    public function typeaheadQuery($q) {
        $peopleRepo = $this->_em->getRepository(People::class);
        $organizationRepo = $this->_em->getRepository(Organization::class);

        $collection = new ArrayCollection(
            array_merge(
                $peopleRepo->typeaheadQuery($q),
                $organizationRepo->typeaheadQuery($q)
            )
        );

        return $collection;
    }

}
