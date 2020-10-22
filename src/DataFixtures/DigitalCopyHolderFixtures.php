<?php

namespace App\DataFixtures;

use App\Entity\DigitalCopyHolder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DigitalCopyHolderFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new DigitalCopyHolder();
        $object->setOrganizationName('Happy Sirens Fishing');
        $em->persist($object);
        $em->flush();
        $this->setReference('DigitalCopyHolder.1', $object);
    }

}
