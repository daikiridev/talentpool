<?php
// src/MyProject/MyBundle/Form/Type/CdteComment.php

namespace TEW\TPBundle\Form;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

// class CdteCommentFormType extends AbstractType
class CdteCommentType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('score', 'choice', array(
                    'choices' => range(0,5),
                    'empty_value'=> ''
            ))
            ->add('comment')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\CdteComment',
        ));

        $resolver->setAllowedTypes(array(
        ));
    }

    public function getName()
    {
        return 'cdtecomment';
    }
}