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
            //->add('globalComment', 'ckeditor', array('config_name' => 'user_config'))
            ->add('globalComment', 'textarea', array(
                'label' => 'General comment',
                'required' => false,
            ))
            ->add('globalScore', 'choice', array(
                'label' => 'Score',
                'required' => false,
                'choices' => range(0,5),
                'empty_value'=> '',
                //'expanded' => true, 'multiple' => false, // radio button
                'attr' => array('class' => 'form-control'),
            ))
            ->add('active', 'checkbox', array(
                'label' => 'visible',
                'required' => false,
                //'attr' => array('class' => 'form-control'),
            ))
            ->add('alert', 'checkbox', array(
                'required' => false,
                //'attr' => array('class' => 'form-control'),
            ))
            ->add('status', 'entity', array(
                'class' => 'TEWTPBundle:CdteStatus',
                'label' => 'Status',
                //'empty_value' => 'All',
                'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('picture', 'sonata_media_type', array(
                'label' => false, // 'label'    =>  'Image'
                'required' => false,
                'provider' => 'sonata.media.provider.image',
                'context'  => 'candidate',
                'attr' => array('class' => 'span16') // doesn't work
            ))
            ->add('gender', 'choice', array(
                'choices' => array('m' => 'Male', 'f' => 'Female'),
                'required' => false,
                'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('firstName', 'text', array(
                'attr' => array('placeholder'=>'First name', 'class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('middleName', 'text', array(
                'required' => false,
                'attr' => array('placeholder'=>'Middle name', 'class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('lastName', 'text', array(
                'attr' => array('placeholder'=>'Last name', 'class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('dateOfBirth', 'date', array(
                'years' => range(date('Y')-20, date('Y')-80),
                'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                'attr' => array('class' => 'date form-control'), // datepicker when available
                'required' => false,
            ))
            ->add('nationality1', 'country', array(
                'required' => false,
                'empty_value' => 'Select',
                'label' => 'Passport country',
                'label_attr' => array('style' => 'color: green'),
                'attr' => array('class' => 'select2'),
            ))
            ->add('nationality2', 'country', array(
                'required' => false,
                'empty_value' => 'Select',
                'label' => 'Passport country2',
                'attr' => array('class' => 'select2')
            ))
            ->add('email1', 'email',  array(
                'required' => false,
                'label_attr' => array('style' => 'color: green'),
                'attr' => array('placeholder'=>'Email1', 'class' => 'form-control')
            ))
            ->add('email2', 'email',  array(
                'required' => false,
                'attr' => array('placeholder'=>'Email2', 'class' => 'form-control')
            ))
            ->add('phone1', 'text', array(
                'required' => true,
                'attr' => array('placeholder'=>'Phone1', 'class' => 'form-control')
            ))
            ->add('phone2', 'text', array(
                'required' => false,
                'attr' => array('placeholder'=>'Phone2', 'class' => 'form-control')
            ))
            // ->add('addresses')
            ->add('addresses', 'modalcollection', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new AddressType(),
                'required' => false,
                'allow_add' => true, // allows to add as many addresses as we want
                'allow_delete' => true,
                'by_reference' => false, // 'false' forces setAddresses() to be called
                ))
            // changing position's label
//            ->add('function', 'entity', array(
//                'class' => 'TEWTPBundle:CdteFunction',
//                'label' => 'Current function',
//                'empty_value' => 'Select',
//                'attr' => array('class' => 'select2 form-control'),
//                //'label_attr' => array('class' => 'col-md-2')
//                ))
            ->add('function', 'entity', array(
                'required' => true,
                'label' => 'Current function',
                'class' => 'TEWTPBundle:CdteFunction',
                'attr' => array('class' => 'select2 form-control'),
                'empty_value' => 'All',
                'property' => 'indentedName',
                'multiple' => false,
                'expanded' => false ,
                'query_builder' => function (\Gedmo\Tree\Entity\Repository\NestedTreeRepository $r)
                    {
                        return $r->getChildrenQueryBuilder(null, null, 'name', 'asc', false);
                    }
            ))
            ->add('level', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'label' => 'Current level',
                'empty_value' => 'All',
                'attr' => array('class' => 'select2  form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('experience', 'choice', array(
                'required' => true,
                'label' => 'Start workg yr',
                'choices' => array_combine(range(date('Y'), date('Y')-50), range(date('Y'), date('Y')-50)),
                'empty_value'=> 'Year',
                'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('income', 'integer', array(
                //'currency' => 'USD', // if type = 'money'
                'label' => 'Base salary',
                'required' => false,
                //'precision' => 0,
                'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
//            ->add('incomeMonths', 'choice', array(
//                //'currency' => 'USD', // if type = 'money'
//                'label' => 'Nb of months',
//                'required' => false,
//                'choices' => array_combine(range(6, 20), range(6, 20)),
//                'empty_value'=> 'Select',
//                'attr' => array('class' => 'form-control'),
//                //'label_attr' => array('class' => 'col-md-2')
//            ))
            ->add('bonusbenefits', 'text', array(
                'label' => 'Additional',
                'attr' => array('class' => 'form-control', 'size' => 80),
                'required' => false,
            ))
            ->add('currency', 'currency', array(
                'attr' => array('class' => 'select2'),
                'empty_value' => 'Select',
                'preferred_choices' => array('USD', 'EUR'),
                'required' => false,
            ))
            ->add('targetFunction1', 'entity', array(
                'required' => false,
                'label' => 'Target function #1',
                'class' => 'TEWTPBundle:CdteFunction',
                'attr' => array('class' => 'select2 form-control'),
                'empty_value' => 'All',
                'property' => 'indentedName',
                'multiple' => false,
                'expanded' => false ,
                'query_builder' => function (\Gedmo\Tree\Entity\Repository\NestedTreeRepository $r)
                    {
                        return $r->getChildrenQueryBuilder(null, null, 'name', 'asc', false);
                    }
            ))
            ->add('targetLevel1', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'required' => false,
                'label' => 'Target level #1',
                'empty_value' => 'All',
                'attr' => array('class' => 'select2'),           
            ))
            ->add('targetFunction2', 'entity', array(
                'required' => false,
                'label' => 'Target function #2',
                'class' => 'TEWTPBundle:CdteFunction',
                'attr' => array('class' => 'select2 form-control'),
                'empty_value' => 'All',
                'property' => 'indentedName',
                'multiple' => false,
                'expanded' => false ,
                'query_builder' => function (\Gedmo\Tree\Entity\Repository\NestedTreeRepository $r){
                        return $r->getChildrenQueryBuilder(null, null, 'name', 'asc', false);
                    }
            ))
            ->add('targetLevel2', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'required' => false,
                'label' => 'Target level #2',
                'empty_value' => 'All',
                'attr' => array('class' => 'select2'),                   
            ))   
            ->add('targetFunction3', 'entity', array(
                'required' => false,
                'label' => 'Target function #3',
                'class' => 'TEWTPBundle:CdteFunction',
                'attr' => array('class' => 'select2 form-control'),
                'empty_value' => 'All',
                'property' => 'indentedName',
                'multiple' => false,
                'expanded' => false ,
                'query_builder' => function (\Gedmo\Tree\Entity\Repository\NestedTreeRepository $r)
                    {
                        return $r->getChildrenQueryBuilder(null, null, 'name', 'asc', false);
                    }
            ))
            ->add('targetLevel3', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'required' => false,
                'label' => 'Target level #3',
                'empty_value' => 'All',
                'attr' => array('class' => 'select2'),                    
            ))
            ->add('mobilities', 'modalcollection', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new CdteMobilityType(),
                'required' => false,
                'allow_add' => true, // allows to add as many locations as we want
                'allow_delete' => false,
                'by_reference' => false, // 'false' forces setMobilities() to be called
            ))
            ->add('languagesSkills', 'modalcollection', array(
                'label' => 'Languages',
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new CdteLanguageType(),
                'required' => false,
                'allow_add' => true, // allows to add as many comments as we want
                'allow_delete' => false,
                'by_reference' => true, // 'false' forces setComments() to be called
            ))
            ->add('talentpools', 'entity', array( 
                'required'  => false,
                'class'    => 'TEWTPBundle:TalentPool',
                'multiple' => true,
                'expanded' => false, // checkboxes?
                'attr' => array('class' => 'select2', 'style' => 'width:300px'),
            ))
            ->add('owningcompany', 'entity', array( 
                'label' => 'Owner',
                'required'  => true,
                'class'    => 'TEWTPBundle:Company',
                'multiple' => false,
                'expanded' => false, // checkboxes?
//                'attr' => array('class' => 'select2', 'style' => 'width:300px'),
            ))
//            ->add('origin', 'choice', array(
//                'choices' => array(
//                    'TEW' => 'TEW', 
//                    'other' => 'other'),
//                'attr' => array('class' => 'form-control'),
//            ))
            ->add('tags','tags', array(
                'required' => false,
                'attr' => array('class' => 'tags-field input-block-level', 'multiple' => 'multiple', 'style' => 'width:300px')
            ))
            ->add('resume', 'sonata_media_type', array(
                'label' => false,
                'required' => false,
                'provider' => 'sonata.media.provider.file',
                'context'  => 'candidate',
                'attr' => array('class' => 'span16') // doesn't work
            ))
            ->add('anonymousResume', 'sonata_media_type', array(
                'label' => false,
                'required' => false,
                'provider' => 'sonata.media.provider.file',
                'context'  => 'candidate',
                'attr' => array('class' => 'span16') // doesn't work
            ))
                    
//            ->add('comments', 'modalcollection', array(
//                'label' => 'User comments',
//                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
//                'type' => new CdteCommentType(),
//                'required' => false,
//                'allow_add' => true, // allows to add as many comments as we want
//                'allow_delete' => false,
//                'by_reference' => false, // 'false' forces setComments() to be called
//            ))
            ;
        $builder->get('picture')
                ->add('binaryContent', 'file', ['label' => false,])
                ->add('unlink', 'hidden', ['mapped' => false, 'data' => false])// removing the 'unlink' checkbox
                ; 
        $builder->get('resume')->add('binaryContent', 'file', ['label' => false,])
                ->add('unlink', 'hidden', ['mapped' => false, 'data' => false]); // removing the 'unlink' checkbox
        $builder->get('anonymousResume')->add('binaryContent', 'file', ['label' => false,])
                ->add('unlink', 'hidden', ['mapped' => false, 'data' => false]); // removing the 'unlink' checkbox
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
        return 'candidate';
    }
}
