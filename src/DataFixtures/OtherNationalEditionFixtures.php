<?php

namespace App\DataFixtures;

use App\Entity\OtherNationalEdition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OtherNationalEditionFixtures extends Fixture implements DependentFixtureInterface {

    public function getDependencies() {
        return [
            PlaceFixtures::class,
            BookFixtures::class,
        ];
    }

    public function load(ObjectManager $em) {
        $object = new OtherNationalEdition();
        $object->setBook($this->getReference('Book.1'));
        $object->setPlace($this->getReference('Place.1'));
        $object->setPublicationDate('1098');
        $em->persist($object);
        $em->flush();
        $this->setReference('OtherNationalEdition.1', $object);
    }

}
