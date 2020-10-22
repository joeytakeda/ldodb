<?php

namespace App\DataFixtures;

use App\Entity\SupplementalPlaceData;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SupplementalPlaceDataFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new SupplementalPlaceData();
        $object->setGeonameId(1);
        $object->setGeoname('Cromwell, Alaska');
        $object->setLatitude('12.0');
        $object->setLongitude('-13.3');
        $em->persist($object);
        $em->flush();
        $this->setReference('SupplementalPlaceData.1', $object);
    }

}
