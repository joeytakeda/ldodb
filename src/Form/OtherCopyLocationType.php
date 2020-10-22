<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * OtherCopyLocationType form.
 */
class OtherCopyLocationType extends AbstractType {

    /**
     * Add form fields to $builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('otherCopyLocation', null, array(
            'label' => 'Other Copy Location',
            'required' => true,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('copyCount', null, array(
            'label' => 'Copy Count',
            'required' => true,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('book', Select2EntityType::class, array(
            'multiple' => false,
            'required' => true,
            'remote_route' => 'book_typeahead',
            'class' => Book::class,
            'primary_key' => 'id',
            'text_property' => 'title',
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
            'data_class' => 'App\Entity\OtherCopyLocation'
        ));
    }

}
