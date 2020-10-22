<?php

namespace App\DataFixtures;

use App\Entity\Keyword;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class KeywordFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new Keyword();
        $object->setKeyword('placodermi');
        $em->persist($object);
        $em->flush();
        $this->setReference('Keyword.1', $object);
    }

}
