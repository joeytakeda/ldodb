<?php

namespace App\DataFixtures;

use App\Entity\PlateType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlateTypeFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new PlateType();
        $object->setPlateType('Bunny');
        $object->setPlateTypeNotes('Plate of a bunny.');
        $em->persist($object);
        $em->flush();
        $this->setReference('PlateType.1', $object);
    }

}
