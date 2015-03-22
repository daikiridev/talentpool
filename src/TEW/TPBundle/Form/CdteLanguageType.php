<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CdteLanguageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language', 'language', array(
                'attr' => array('class' => 'select2')
            ))
            ->add('skill', 'choice', array(
                'choices' => array('none','beginner','intermediate','fluent', 'mother tongue'),
                //'attr' => array('class' => 'select2')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\CdteLanguage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cdtelanguage';
    }
}
