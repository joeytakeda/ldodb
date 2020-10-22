<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new Genre();
        $object->setGenreName('extinct');
        $object->setGenreSource('phylogenic studies');
        $object->setGenreUri('http://example.com/genre/extinct');
        $object->setGenreUsageNote('Not to be used with Dunkleosteus because they rock.');
        $em->persist($object);
        $em->flush();
        $this->setReference('Genre.1', $object);
    }

}
