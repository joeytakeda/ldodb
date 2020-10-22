<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface {

    public function getDependencies() {
        return [
            MapTypeFixtures::class,
            SubjectFixtures::class,
            BindingFeatureFixtures::class,
            PlateTypeFixtures::class,
            MapSizeFixtures::class,
            SubjectHeadingFixtures::class,
            KeywordFixtures::class,
            ReferencedPersonFixtures::class,
            GenreFixtures::class,
            DigitalCopyHolderFixtures::class,
        ];
    }

    public function load(ObjectManager $em) {
        $object = new Book();
        $object->setBibliographicNotes('cheese');
        $object->setBicknellNumber('123 234');
        $object->setBindingColour('cheese coloured.');
        $object->setBritishEdition('first');
        $object->setCallNumber('PB 10 JAM 9');
        $object->setCopies(3);
        $object->setCriticalAnnotation('A good, not great, book.');
        $object->setDedication('To my wife, a very good fish.');
        $object->setEdition('second');
        $object->setFileName('coelacanth123');
        $object->setFormat('gilled');
        $object->setHealeyNumber('H 102');
        $object->setIllustrations('3 with salt water');
        $object->setImprint('Blubs');
        $object->setMapCount(1);
        $object->setOriginalBib('what goes here?');
        $object->setPages(12);
        $object->setPhotographs('three');
        $object->setPlateCount(9);
        $object->setPrice("1.2 duckets.");
        $object->setPrintRun(10);
        $object->setPublicDomain(true);
        $object->setPublicationDate('1098');
        $object->setReedNumber('R 12');
        $object->setSeriesTitle('Sharks and Sharkery');
        $object->setSfuCatOrigBib('PB 123');
        $object->setShortTitle('Sharkery Part 2');
        $object->setTitle('How to Sharks with Sharkers, Advanced');
        $object->setTitlePageQuotation('The various fish groups account for more than half of vertebrate species. There are almost 28,000 known extant species, of which almost 27,000 are bony fish.');
        $object->setVolumes(7);

        $object->addBindingFeature($this->getReference('BindingFeature.1'));
        $object->addDigitalCopyHolder($this->getReference('DigitalCopyHolder.1'));
        $object->addGenre($this->getReference('Genre.1'));
        $object->addKeyword($this->getReference('Keyword.1'));
        $object->addMapSize($this->getReference('MapSize.1'));
        $object->addMapType($this->getReference('MapType.1'));
        $object->addPlateType($this->getReference('PlateType.1'));
        $object->addReferencedPerson($this->getReference('ReferencedPerson.1'));
        $object->addSubject($this->getReference('Subject.1'));
        $object->addSubjectHeading($this->getReference('SubjectHeading.1'));

        $em->persist($object);
        $this->setReference('Book.1', $object);

        $em->flush();
    }

}
