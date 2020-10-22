<?php

namespace App\Form;

use App\Entity\Contribution;
use App\Entity\Entity;
use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * ContributionType form.
 */
class ContributionType extends AbstractType {

    /**
     * Add form fields to $builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('entity', Select2EntityType::class, array(
            'multiple' => false,
            'remote_route' => 'entity_typeahead',
            'class' => Entity::class,
            'primary_key' => 'id',
            'text_property' => 'asString',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'en',
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('task', Select2EntityType::class, array(
            'multiple' => false,
            'remote_route' => 'task_typeahead',
            'class' => Task::class,
            'primary_key' => 'id',
            'text_property' => 'taskName',
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
            'data_class' => Contribution::class
        ));
    }

}
