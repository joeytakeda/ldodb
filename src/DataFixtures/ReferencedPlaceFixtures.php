<?php

namespace App\DataFixtures;

use App\Entity\ReferencedPlace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReferencedPlaceFixtures extends Fixture implements DependentFixtureInterface {

    public function getDependencies() {
        return [
            BookFixtures::class,
            PlaceFixtures::class,
        ];
    }

    public function load(ObjectManager $em) {
        $object = new ReferencedPlace();
        $object->setBook($this->getReference('Book.1'));
        $object->setPlace($this->getReference('Place.1'));
        $object->setVariantSpelling('placodermi');
        $em->persist($object);
        $em->flush();
        $this->setReference('ReferencedPlace.1', $object);
    }

}
