<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TalentPoolType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('positions')
            //->add('languagesSkills')
            //->add('creationDate') // see __construct()
            //->add('creator') // see __construct()
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\TalentPool'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'talentpool';
    }
}
