<?php

namespace App\DataFixtures;

use App\Entity\OtherCopyLocation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OtherCopyLocationFixtures extends Fixture implements DependentFixtureInterface {

    public function getDependencies() {
        return [
            BookFixtures::class,
        ];
    }

    public function load(ObjectManager $em) {
        $object = new OtherCopyLocation();
        $object->setBook($this->getReference('Book.1'));
        $object->setCopyCount(2);
        $object->setOtherCopyLocation('Codswallop');
        $em->persist($object);
        $em->flush();
        $this->setReference('OtherCopyLocation.1', $object);
    }

}
