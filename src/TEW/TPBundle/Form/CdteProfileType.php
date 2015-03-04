<?php
// src/MyProject/MyBundle/Form/Type/CdteProfileType.php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class CdteProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('function')
            ->add('level')
            ->add('description', 'ckeditor', array('config_name' => 'user_config'))
            ->add('mobilities', 'modalcollection', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new ProfileMobilityType(),
                'required' => false,
                'allow_add' => true, // allows to add as many locations as we want
                'allow_delete' => false,
                'by_reference' => false, // 'false' forces setMobilities() to be called
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'                => 'TEW\TPBundle\Entity\CdteProfile',
        ));

        $resolver->setAllowedTypes(array(
        ));
    }

    public function getName()
    {
        return 'cdtefunction';
    }
}