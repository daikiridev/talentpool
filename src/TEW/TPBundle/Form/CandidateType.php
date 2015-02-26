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
            ->add('globalComment', 'ckeditor', array(
                'config' => array(
                    'toolbar' => array(
//config.toolbar_Full =
//[
//    { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
//    { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
//    { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
//    { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
//    '/',
//    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
//    { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
//    { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
//    { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
//    '/',
//    { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
//    { name: 'colors',      items : [ 'TextColor','BGColor' ] },
//    { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] }
//];                    
                        array(
                            'name' => 'clipboard',
                            'items' => array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'),
                        ),
                        array(
                            'name'  => 'basicstyles',
                            'items' => array('Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat'),
                        ),
                        array(
                            'name' => 'paragraph',
                            'items' => array('NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
                            
                        ),
                        array(
                            'name' => 'links',
                            'items' => array('Link','Unlink'),
                        )
                        //'/',
                    ),
                    'uiColor' => '#ffffff',
                ),
            ))
            ->add('globalScore', 'choice', array(
                'choices' => range(0,5),
                'empty_value'=> '',
                'attr' => array('class' => 'select2'),
            ))
            ->add('active', 'checkbox', array('required' => false))
            ->add('picture', 'sonata_media_type', array(
                'label' => false, // 'label'    =>  'Image'
                'required' => false,
                'provider' => 'sonata.media.provider.image',
                'context'  => 'candidate',
                'attr' => array('class' => 'span16') // doesn't work
            ))
            ->add('gender', 'choice', array(
                'choices' => array('m' => 'Male', 'f' => 'Female'),
                'attr' => array('class' => 'select2'),
            ))
            ->add('firstName')
            ->add('middleName', 'text', array('required' => false))
            ->add('lastName')
            ->add('dateOfBirth', 'date', array(
                'years' => range(date('Y')-20, date('Y')-80),
                'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                'attr' => array('class' => 'date select2'), // datepicker when available
            ))
            ->add('email', 'email')
            ->add('phone1')
            ->add('phone2', 'text', array('required' => false))
            // ->add('addresses')
            ->add('addresses', 'collection', array(
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
                'attr' => array('class' => 'select2'),
                ))
            ->add('level', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'label' => 'Current level',
                'empty_value' => 'Select',
                'attr' => array('class' => 'select2'),                   
                ))
            ->add('experience', 'choice', array(
                'label' => 'Experience',
                'choices' => range(0,40),
                'empty_value'=> 'Yrs',
                'attr' => array('class' => 'select2'),
            ))
            ->add('annualIncome')
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
                'attr' => array(
                    'class' => 'select2'
                    ),                    
                ))
            ->add('targetFunction2', 'entity', array(
                'class' => 'TEWTPBundle:CdteFunction',
                'required' => false,
                'label' => 'Target function #2',
                'empty_value' => 'Select',
                'attr' => array(
                    'class' => 'select2'
                    ),
                ))
            ->add('targetLevel2', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'required' => false,
                'label' => 'Target level #2',
                'empty_value' => 'Select',
                'attr' => array(
                    'class' => 'select2'
                    ),                    
                ))   
            ->add('targetFunction3', 'entity', array(
                'class' => 'TEWTPBundle:CdteFunction',
                'required' => false,
                'label' => 'Target function #3',
                'empty_value' => 'Select',
                'attr' => array(
                    'class' => 'select2'
                    ),
                ))
            ->add('targetLevel3', 'entity', array(
                'class' => 'TEWTPBundle:CdteLevel',
                'required' => false,
                'label' => 'Target level #3',
                'empty_value' => 'Select',
                'attr' => array(
                    'class' => 'select2'
                    ),                    
                ))
            ->add('mobilities', 'collection', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new CdteMobilityType(),
                'required' => false,
                'allow_add' => true, // allows to add as many locations as we want
                'allow_delete' => false,
                'by_reference' => false, // 'false' forces setMobilities() to be called
                ))
            ->add('languagesSkills', 'collection', array(
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
            ->add('origin')
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
            ->add('comments', 'collection', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new CdteCommentType(),
                'required' => false,
                'allow_add' => true, // allows to add as many comments as we want
                'allow_delete' => false,
                'by_reference' => false, // 'false' forces setComments() to be called
                ))
            ;
        $builder->get('picture')->add('binaryContent', 'file', ['label' => false,])
                ->add('unlink', 'hidden', ['mapped' => false, 'data' => false]); // removing the 'unlink' checkbox
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
