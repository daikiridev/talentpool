<?php
// src/TEW/TPBundle/Form/ModalCollectionType.php
namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CheckCandidatesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('candidates', 'entity', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'class' => 'TEWTPBundle:Candidate',
                'required' => true,
                'expanded' => true,
                'multiple' => true,
                ))
            ->add('selectactions', 'choice', array(
                'empty_value' => 'Select an action',
                'choices' => array('compare' => 'Show selected candidates'),
                'attr' => array('class' => 'form-control'),
            ))
            ->add('submit', 'submit', array(
                'label' => 'Go',
                'attr' => array('class' => 'btn btn-xs btn-info', 'style' => "margin-top: 7px"),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

//    public function getParent()
//    {
//        return 'collection';
//    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'checkcandidates';
    }
}