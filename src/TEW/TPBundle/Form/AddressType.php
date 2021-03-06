<?php
// src/MyProject/MyBundle/Form/Type/Address.php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

// class AddressFormType extends AbstractType
class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', 'choice', array('choices' => array('Home' => 'Home', 'Work' => 'Work', 'Other' => 'Other')))
            ->add('street1', 'text', array('attr' => array('size' => '50')))
            ->add('street2', 'text', array('required' => false))
            ->add('zip', 'text', array('required' => false))
            ->add('city', 'text')
            ->add('province', 'text', array('required' => false))
            ->add('country', 'text')
//            ->add('selectData', 'select_city', array(
//                'country_required'  => $options['country_required'],
//                //'state_required'    => $options['state_required'], // doesn't work...
//                'city_required'     => $options['city_required'],
//            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'                => 'TEW\TPBundle\Entity\Address',
//            'country_required'          => true,
//            'state_required'            => false,
//            'city_required'             => true,
        ));

        $resolver->setAllowedTypes(array(
//            'country_required'          => 'bool',
//            'state_required'            => 'bool',
//            'city_required'             => 'bool',
        ));
    }

    public function getName()
    {
        return 'address';
    }
}