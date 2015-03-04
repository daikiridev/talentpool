<?php
// src/MyProject/MyBundle/Form/Type/CdteFunctionType.php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class CdteFunctionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('name')
            ->add('function', 'entity', array(
                'required' => false,
                'label' => 'Function parent',
                'class' => 'TEWTPBundle:CdteFunction',
                'attr' => array('class' => 'col-sm-8'),
                'empty_value' => 'Select one category',
                'property' => 'indentedName',
                'multiple' => false,
                'expanded' => false ,
                'query_builder' => function (\TEW\TPBundle\Entity\CdteFunctionRepository $r)
                    {
                        return $r->getChildrenQueryBuilder(null, null, 'root', 'asc', false);
                    }
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'                => 'TEW\TPBundle\Entity\CdteFunction',
        ));

        $resolver->setAllowedTypes(array(
        ));
    }

    public function getName()
    {
        return 'cdtefunction';
    }
}