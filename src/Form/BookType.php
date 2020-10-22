<?php

namespace App\Form;

use App\Entity\BindingFeature;
use App\Entity\DigitalCopyHolder;
use App\Entity\Genre;
use App\Entity\Keyword;
use App\Entity\MapSize;
use App\Entity\MapType;
use App\Entity\Place;
use App\Entity\PlateType;
use App\Entity\ReferencedPerson;
use App\Entity\Subject;
use App\Entity\SubjectHeading;
use Symfony\Bridge\Doctrine\Form\Type\EntityType as SymfonyEntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * BookType form.
 */
class BookType extends AbstractType {

    /**
     * Add form fields to $builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('fileName', null, array(
            'label' => 'File Name',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('callNumber', null, array(
            'label' => 'Call Number',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('title', null, array(
            'label' => 'Title',
            'required' => true,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('shortTitle', null, array(
            'label' => 'Short Title',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('seriesTitle', null, array(
            'label' => 'Series Title',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('titlePageQuotation', null, array(
            'label' => 'Title Page Quotation',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('dedication', null, array(
            'label' => 'Dedication',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('imprint', null, array(
            'label' => 'Imprint',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('edition', null, array(
            'label' => 'Edition',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('publicationDate', null, array(
            'label' => 'Publication Date',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('volumes', IntegerType::class, array(
            'label' => 'Volumes',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('pages', IntegerType::class, array(
            'label' => 'Pages',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('copies', IntegerType::class, array(
            'label' => 'Copies',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('sfuCatOrigBib', null, array(
            'label' => 'Sfu Cat Orig Bib',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('sfuDigitalCopy', null, array(
            'label' => 'SFU Digital Copy',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('originalBib', ChoiceType::class, array(
            'label' => 'Original Bib',
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                'Yes' => true,
                'No' => false,
                'Unknown' => null,
            ),
            'required' => false,
            'placeholder' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('bicknellNumber', null, array(
            'label' => 'Bicknell Number',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('healeyNumber', null, array(
            'label' => 'Healey Number',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('reedNumber', null, array(
            'label' => 'Reed Number',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('publicDomain', ChoiceType::class, array(
            'label' => 'Public Domain',
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                'Yes' => true,
                'No' => false,
                'Unknown' => null,
            ),
            'required' => false,
            'placeholder' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('britishEdition', null, array(
            'label' => 'British Edition',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('price', null, array(
            'label' => 'Price',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('printRun', null, array(
            'label' => 'Print Run',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('bookUri', UrlType::class, array(
            'label' => 'Book Uri',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('digitalObjectUrl', UrlType::class, array(
            'label' => 'Digital Object Url',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('bibliographicNotes', null, array(
            'label' => 'Bibliographic Notes',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('criticalAnnotation', null, array(
            'label' => 'Critical Annotation',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('format', null, array(
            'label' => 'Format',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('plateCount', IntegerType::class, array(
            'label' => 'Plate Count',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('mapCount', IntegerType::class, array(
            'label' => 'Map Count',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('illustrations', null, array(
            'label' => 'Illustrations',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('photographs', null, array(
            'label' => 'Photographs',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('tables', ChoiceType::class, array(
            'label' => 'Tables',
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                'Yes' => true,
                'No' => false,
                'Unknown' => null,
            ),
            'required' => false,
            'placeholder' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('bindingColour', null, array(
            'label' => 'Binding Colour',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('contributions', CollectionType::class, array(
            'label' => 'Contributions',
            'required' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'entry_type' => ContributionType::class,
            'entry_options' => array(
                'label' => false,
            ),
            'by_reference' => true,
            'attr' => array(
                'class' => 'collection collection-complex',
                'help_block' => '',
            ),
        ));
        $builder->add('genres', Select2EntityType::class, array(
            'multiple' => true,
            'remote_route' => 'genre_typeahead',
            'class' => Genre::class,
            'primary_key' => 'id',
            'text_property' => 'genreName',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'en',
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('referencedPeople', Select2EntityType::class, array(
            'multiple' => true,
            'remote_route' => 'referenced_person_typeahead',
            'class' => ReferencedPerson::class,
            'primary_key' => 'id',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'en',
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('plateTypes', SymfonyEntityType::class, array(
            'class' => PlateType::class,
            'multiple' => true,
            'expanded' => true,
        ));
        $builder->add('mapTypes', SymfonyEntityType::class, array(
            'class' => MapType::class,
            'multiple' => true,
            'expanded' => true,
        ));
        $builder->add('subjects', Select2EntityType::class, array(
            'multiple' => true,
            'remote_route' => 'subject_typeahead',
            'class' => Subject::class,
            'primary_key' => 'id',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'en',
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('mapSizes', SymfonyEntityType::class, array(
            'class' => MapSize::class,
            'multiple' => true,
            'expanded' => true,
        ));
        $builder->add('subjectHeadings', Select2EntityType::class, array(
            'multiple' => true,
            'remote_route' => 'subject_heading_typeahead',
            'class' => SubjectHeading::class,
            'primary_key' => 'id',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'en',
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('bindingFeatures', SymfonyEntityType::class, array(
            'class' => BindingFeature::class,
            'multiple' => true,
            'expanded' => true,
        ));
        $builder->add('keywords', Select2EntityType::class, array(
            'multiple' => true,
            'remote_route' => 'keyword_typeahead',
            'class' => Keyword::class,
            'primary_key' => 'id',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'en',
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('digitalCopyHolders', SymfonyEntityType::class, array(
            'class' => DigitalCopyHolder::class,
            'multiple' => true,
            'expanded' => true,
        ));
        $builder->add('publicationPlaces', Select2EntityType::class, array(
            'multiple' => true,
            'remote_route' => 'place_typeahead',
            'class' => Place::class,
            'primary_key' => 'id',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'en',
            'attr' => array(
                'help_block' => '',
            ),
        ));
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Book'
        ));
    }

}
