<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new Role();
        $object->setRoleName('fishmonger');
        $em->persist($object);
        $em->flush();
        $this->setReference('Role.1', $object);
    }

}
