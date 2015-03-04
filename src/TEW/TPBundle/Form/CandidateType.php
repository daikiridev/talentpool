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
            ->add('globalComment', 'ckeditor', array('config_name' => 'user_config'))
            ->add('globalScore', 'choice', array(
                'choices' => range(0,5),
                //'empty_value'=> '',
                'expanded' => true, 'multiple' => false, // radio button
                'attr' => array('class' => 'form-control'),
            ))
            ->add('active', 'checkbox', array(
                'required' => false,
                'attr' => array('class' => 'form-control'),
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
            ))
            ->add('email', 'email',  array(
                'attr' => array('placeholder'=>'Email', 'class' => 'form-control')
            ))
            ->add('phone1', 'text', array(
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
            ->add('function', 'entity', array(
                'class' => 'TEWTPBundle:CdteFunction',
                'label' => 'Current function',
                'empty_value' => 'Select',
                'attr' => array('class' => 'select2 form-control'),
                //'label_attr' => array('class' => 'col-md-2')
                ))
            ->add('level', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'label' => 'Current level',
                'empty_value' => 'Select',
                'attr' => array('class' => 'select2  form-control'),
                //'label_attr' => array('class' => 'col-md-2')
                ))
            ->add('experience', 'choice', array(
                'label' => 'Experience',
                'choices' => range(0,40),
                'empty_value'=> 'Yrs',
                'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('annualIncome', 'integer', array(
                //'currency' => 'USD', // if type = 'money'
                'attr' => array('class' => 'form-control'),
                //'label_attr' => array('class' => 'col-md-2')
            ))
            ->add('targetFunction1', 'entity', array(
                'class' => 'TEWTPBundle:CdteFunction',
                'required' => false,
                'label' => 'Target function #1',
                'empty_value' => 'Select',
                'attr' => array('class' => 'select2'),
            ))
            ->add('targetLevel1', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'required' => false,
                'label' => 'Target level #1',
                'empty_value' => 'Select',
                'attr' => array('class' => 'select2'),           
            ))
            ->add('targetFunction2', 'entity', array(
                'class' => 'TEWTPBundle:CdteFunction',
                'required' => false,
                'label' => 'Target function #2',
                'empty_value' => 'Select',
                'attr' => array('class' => 'select2'), 
            ))
            ->add('targetLevel2', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'required' => false,
                'label' => 'Target level #2',
                'empty_value' => 'Select',
                'attr' => array('class' => 'select2'),                   
            ))   
            ->add('targetFunction3', 'entity', array(
                'class' => 'TEWTPBundle:CdteFunction',
                'required' => false,
                'label' => 'Target function #3',
                'empty_value' => 'Select',
                'attr' => array('class' => 'select2'), 
            ))
            ->add('targetLevel3', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'required' => false,
                'label' => 'Target level #3',
                'empty_value' => 'Select',
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
            ->add('origin', 'text', array(
                'attr' => array('class' => 'form-control')
            ))
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
            ->add('comments', 'modalcollection', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new CdteCommentType(),
                'required' => false,
                'allow_add' => true, // allows to add as many comments as we want
                'allow_delete' => false,
                'by_reference' => false, // 'false' forces setComments() to be called
            ))
            ;
        $builder->get('picture')
                ->add('binaryContent', 'file', ['label' => false,])
                ->add('unlink', 'hidden', ['mapped' => false, 'data' => false])// removing the 'unlink' checkbox
                ; 
        $builder->get('resume')->add('binaryContent', 'file', ['label' => false,])
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
