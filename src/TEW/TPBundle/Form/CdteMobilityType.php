<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CdteMobilityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location', 'text', array('attr' => array('size' => '50')))
            ->add('zone', 'hidden', array('required' => false, 'attr' => array('class'=>'mobility_zone')))
            ->add('country', 'hidden', array('required' => false, 'attr' => array('class'=>'mobility_country')))
            ->add('region', 'hidden', array('required' => false))
            ->add('city', 'hidden', array('required' => false))  
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\CdteMobility'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cdtemobility';
    }
}
