<?php

namespace AppBundle\Tests\DataFixtures\ORM;

use AppBundle\Entity\OtherCopyLocation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadOtherCopyLocation extends AbstractFixture {
    
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