<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new Organization();
        $object->setOrganizationName('Fisherwomen Inc.');
        $object->setOrganizationNotes('Group of Fisherwomen in search of Groupers.');
        $object->setOrganizationUri('http://example.com/organization/fisherwomen-inc');
        $em->persist($object);
        $em->flush();
        $this->setReference('Organization.1', $object);
    }

}
