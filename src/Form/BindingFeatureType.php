<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * BindingFeatureType form.
 */
class BindingFeatureType extends AbstractType {

    /**
     * Add form fields to $builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('bindingFeature', null, array(
            'label' => 'Binding Feature',
            'required' => true,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('bindingFeatureNotes', null, array(
            'label' => 'Binding Feature Notes',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('books');
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
            'data_class' => 'App\Entity\BindingFeature'
        ));
    }

}
