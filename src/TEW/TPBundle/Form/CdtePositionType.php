<?php
// src/MyProject/MyBundle/Form/Type/CdtePosition.php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

// class AddressFormType extends AbstractType
class CdtePositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('function')
            ->add('level')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'                => 'TEW\TPBundle\Entity\CdtePosition',
        ));

        $resolver->setAllowedTypes(array(
        ));
    }

    public function getName()
    {
        return 'address';
    }
}