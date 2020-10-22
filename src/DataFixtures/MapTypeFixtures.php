<?php

namespace App\DataFixtures;

use App\Entity\MapType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MapTypeFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new MapType();
        $object->setMapType('chum');
        $object->setMapTypeNotes('Map of chum.');
        $em->persist($object);
        $em->flush();
        $this->setReference('MapType.1', $object);
    }

}
