<?php

namespace App\DataFixtures;

use App\Entity\BibliographicTerms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BibliographicTermsFixtures extends Fixture {

    public function load(ObjectManager $em) {
        $object = new BibliographicTerms();
        $object->setBibliographicTerm('fins');
        $object->setUseForFormat(true);
        $object->setUseForIllustrations(true);
        $object->setUseForPhotographs(true);
        $em->persist($object);
        $em->flush();
        $this->setReference('BibliographicTerms.1', $object);
    }

}
