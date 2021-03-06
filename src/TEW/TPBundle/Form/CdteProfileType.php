<?php
// src/MyProject/MyBundle/Form/Type/CdteProfileType.php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class CdteProfileType extends AbstractType
{
    protected $companyId;
    
    public function __construct($id)
    {
        $this->companyId=$id;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->companyId;
        
        $builder
            ->add('title')
            ->add('function', 'entity', array(
                'required' => false,
                'class' => 'TEWTPBundle:CdteFunction',
                'attr' => array('class' => 'select2 form-control', 'style' => 'width:300px'),
                'empty_value' => 'All',
                'property' => 'indentedName',
                'multiple' => false,
                'expanded' => false ,
//                'query_builder' => function (\Gedmo\Tree\Entity\Repository\NestedTreeRepository $r){
//                        return $r->getChildrenQueryBuilder(null, null, 'root', 'asc', false);
//                    }
                'query_builder' => function(\Gedmo\Tree\Entity\Repository\NestedTreeRepository $er) use ($id) {
                    return $er->createQueryBuilder('fun')
                                ->join('fun.companies', 'cie')
                                ->where('cie.id = :id')
                                ->setParameter('id', $id);
                },
            ))
            ->add('level', 'entity', array(
                'required' => false,
                'class' => 'TEWTPBundle:CdteLevel',
                'attr' => array('class' => 'select2 form-control', 'style' => 'width:300px'),
                'empty_value' => 'All',
                'property' => 'name',
                'multiple' => false,
                'expanded' => false ,
            ))
            //->add('description', 'ckeditor', array('config_name' => 'user_config'))
            ->add('description', 'textarea', array(
                'attr' => array('cols' => '80', 'rows' => '10')
            ))
            ->add('locations', 'modalcollection', array(
                'label' => 'Locations',
                'attr' => array('class' => 'form-collection modal-collection'), // in order to handle jquery functions of tew.candidate.edit.js
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