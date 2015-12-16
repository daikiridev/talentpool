<?php
// src/MyProject/MyBundle/Form/Type/CdteNote.php

namespace TEW\TPBundle\Form;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

// class CdteNoteFormType extends AbstractType
class CdteNoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'New note title',
            ))
            ->add('candidate', 'entity', array(
                'class' => 'TEWTPBundle:Candidate',
                'label' => false,
                'required' => false,
                'attr' => array('style' => 'display:none')
            ))
            ->add('author', 'entity', array(
                'class' => 'TEWUserBundle:User',
                'label' => false,
                'required' => false,
                'attr' => array('style' => 'display:none')
            ))
            ->add('note', 'textarea', array(
                'label' => 'Description',
                'required' => true,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\CdteNote',
        ));

        $resolver->setAllowedTypes(array(
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cdtenote';
    }
}