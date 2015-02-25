<?php
// src/MyProject/MyBundle/Form/Type/CdteComment.php

namespace TEW\TPBundle\Form;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

// class CdteCommentFormType extends AbstractType
class CdteCommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('score', 'choice', array(
                    'choices' => range(0,5),
                    'empty_value'=> ''
            ))
            ->add('comment', 'ckeditor', array(
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
            ->add('talentpool')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\CdteComment',
        ));

        $resolver->setAllowedTypes(array(
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cdtecomment';
    }
}