<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CandidateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('gender', 'choice', array(
                    'choices' => array('m' => 'Male', 'f' => 'Female'),
                ))
                ->add('firstName')
                ->add('middleName', 'text', array(
                    'required' => false,
                ))
                ->add('lastName')
                ->add('dateOfBirth', 'date', array(
                    'years' => range('1940', date('Y')-20),
                    'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                    'attr' => array('class' => 'date'), // datepicker when available
                ))
                ->add('email', 'email')
                ->add('phone1')
                ->add('phone2')
                ->add('position')
                ->add('targetPositions')
               // ->add('languagesSkills')
                ->add('talentpools')
                ->add('level')
        //->add('comments')
        //->add("creationDate", "date", array("mapped"=>false))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\Candidate'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tew_tpbundle_candidate';
    }
}
