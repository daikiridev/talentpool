<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class CdteSearchType extends AbstractType
{
    protected $companyId;
    private $securityContext;

    
    public function __construct(SecurityContext $securityContext, $id=null)
    {
        $this->securityContext = $securityContext;
        $this->companyId=$id;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->companyId;
        
        $builder
//            ->add('invisible', 'checkbox', array(
//                'required' => false,
//                //'attr' => array('class' => 'form-control'),
//            ))
            ->add('alert', 'checkbox', array(
                'required' => false,
                //'attr' => array('class' => 'form-control'),
            ))
            ->add('status', 'entity', array(
                'required' => false,
                'class' => 'TEWTPBundle:CdteStatus',
                'label' => 'Status',
                'multiple' => true,
                'expanded' => false,
//                'empty_value' => 'All',
                'attr' => array('class' => 'select2', 'style' => 'width:190px'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('function', 'entity', array(
                'required' => false,
                'label' => 'Current function',
                'class' => 'TEWTPBundle:CdteFunction',
                'attr' => array('class' => 'select2 form-control'),
                'empty_value' => 'All',
                'property' => $this->securityContext->isGranted('ROLE_TEW_STD_EXECUTOR')?'indentedName':'name',
                'multiple' => false,
                'expanded' => false ,
//                'query_builder' => function (\Gedmo\Tree\Entity\Repository\NestedTreeRepository $r)
//                    {
//                        return $r->getChildrenQueryBuilder(null, null, 'name', 'asc', false);
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
                'label' => 'Current level',
                'empty_value' => 'All',
                'attr' => array('class' => 'select2  form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('experience', 'choice', array(
                'required' => false,
                'label' => 'Experience (yrs)',
                'choices' => array_combine(range(0, 50), array_map(function($y) {return ">$y"; }, range(0, 50))),
                'empty_value'=> 'All',
                'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('keywords', 'entity', array(
                'required' => false,
                'label' => 'Keywords',
                'class' => 'TEWTPBundle:CdteKeyword',
                'attr' => array('class' => 'select2 form-control', 'style' => 'width:300px'),
                'empty_value' => 'All',
                'multiple' => true,
                'expanded' => false,
                'query_builder' => function(\TEW\TPBundle\Entity\CdteKeywordRepository $er) use ($id) {
                    return $er->createQueryBuilder('kw')
                                ->join('kw.companies', 'cie')
                                ->where('cie.id = :id')
                                ->setParameter('id', $id);
                },
            ))
            ->add("owningcompany", 'entity', array(
                'required' => false,
                'class' => 'TEWTPBundle:Company',
                'label' => 'Owner',
                'empty_value' => 'All',
                'attr' => array('class' => 'select2  form-control'),
                //'label_attr' => array('class' => 'col-md-2')
                'query_builder' => function (\TEW\TPBundle\Entity\CompanyRepository $r) use ($id)
                    {
                        return ($id && !$this->securityContext->isGranted('ROLE_TEW_MASTER_EXECUTOR'))?
                                $r->createQueryBuilder('cie')
                                ->where('cie.id = :id')
                                ->setParameter('id', $id)
                                :
                                $r->createQueryBuilder('cie');
                    }
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
