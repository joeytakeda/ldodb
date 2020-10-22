<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new Task();
        $object->setTaskName('Cromulator');
        $em->persist($object);
        $em->flush();
        $this->setReference('Task.1', $object);
    }

}
