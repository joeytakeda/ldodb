<?php

namespace App\Form;

use App\Entity\SubjectHeading;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * SubjectHeadingType form.
 */
class SubjectHeadingType extends AbstractType {

    /**
     * Add form fields to $builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('subjectHeading', null, array(
            'label' => 'Subject Heading',
            'required' => true,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('subjectHeadingUri', UrlType::class, array(
            'label' => 'Subject Heading Uri',
            'required' => false,
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
            'data_class' => SubjectHeading::class
        ));
    }

}
