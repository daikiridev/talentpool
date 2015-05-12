<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CdteSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('invisible', 'checkbox', array(
                'required' => false,
                //'attr' => array('class' => 'form-control'),
            ))
            ->add('alert', 'checkbox', array(
                'required' => false,
                //'attr' => array('class' => 'form-control'),
            ))
            ->add('status', 'entity', array(
                'required' => false,
                'class' => 'TEWTPBundle:CdteStatus',
                'label' => 'Status',
                'multiple' => true,
                'expanded' => true,
                'empty_value' => 'All',
                //'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('function', 'entity', array(
                'required' => false,
                'label' => 'Current function',
                'class' => 'TEWTPBundle:CdteFunction',
                'attr' => array('class' => 'select2 form-control'),
//                'empty_value' => 'All',
                'property' => 'indentedName',
                'multiple' => false,
                'expanded' => false ,
                'query_builder' => function (\Gedmo\Tree\Entity\Repository\NestedTreeRepository $r)
                    {
                        return $r->getChildrenQueryBuilder(null, null, 'name', 'asc', false);
                    }
            ))
            ->add('level', 'entity', array(
                'required' => false,
                'class' => 'TEWTPBundle:CdteLevel',
                'label' => 'Current level',
//                'empty_value' => 'All',
                'attr' => array('class' => 'select2  form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('experience', 'choice', array(
                'required' => false,
                'label' => 'Experience (yrs)',
                'choices' => array_combine(range(0, 50), array_map(function($y) {return ">$y"; }, range(0, 50))),
//                'empty_value'=> 'All',
                'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add("owningcompany", 'entity', array(
                'required' => false,
                'class' => 'TEWTPBundle:Company',
                'label' => 'Owner',
//                'empty_value' => 'All',
                'attr' => array('class' => 'select2  form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
/*
            ->add('firstName', 'text', array(
                'required' => false,
                'attr' => array('placeholder'=>'First name', 'class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('middleName', 'text', array(
                'required' => false,
                'attr' => array('placeholder'=>'Middle name', 'class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('lastName', 'text', array(
                'required' => false,
                'attr' => array('placeholder'=>'Last name', 'class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('nationality1', 'country', array(
                'required' => false,
                'attr' => array('class' => 'select2')
            ))
            ->add('nationality2', 'country', array(
                'required' => false,
                'attr' => array('class' => 'select2')
            ))
            ->add('mobilities', 'entity', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'class' => 'TEWTPBundle:CdteMobility',
                'required' => false,
                'multiple' => true,
//                'by_reference' => false, // 'false' forces setMobilities() to be called
            ))
            ->add('languagesSkills', 'entity', array(
                'label' => 'Languages',
                //'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'class' => 'TEWTPBundle:CdteLanguage',
                'required' => false,
                'multiple' => true,
//                'by_reference' => true, // 'false' forces setComments() to be called
            ))
//            ->add('tags','tags', array(
//                'required' => false,
//                'attr' => array('class' => 'tags-field input-block-level', 'multiple' => 'multiple', 'style' => 'width:300px')
//            ))

 */
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
//            'data_class' => 'TEW\TPBundle\Entity\CdteSearch'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cdtesearch';
    }
}
