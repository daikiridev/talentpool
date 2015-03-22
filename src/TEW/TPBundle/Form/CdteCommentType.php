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
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'Candidate overview',
            ))
            ->add('talentpool', 'entity', array(
                'required' => true,
                'label' => 'Target talentpool',
                'class' => 'TEWTPBundle:TalentPool',
                'attr' => array('class' => 'select2 form-control'),
                //'empty_value' => 'All',
                'multiple' => false, 'expanded' => false,
            ))
            ->add('score', 'choice', array(
                'choices' => range(0,5),
                'empty_value'=> '',
                //'expanded' => true, 'multiple' => false, // radio button : memory error!!!
                'attr' => array('class' => 'form-control'),
            ))
            //->add('comment', 'ckeditor', array('config_name' => 'user_config'))
            ->add('comment', 'textarea', array(
                'label' => 'Detailed comment',
                'required' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\CdteComment',
        ));

        $resolver->setAllowedTypes(array(
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cdtecomment';
    }
}