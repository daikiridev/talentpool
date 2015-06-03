<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TalentPoolType extends AbstractType
{
    protected $companyId;
    
    public function __construct($id=null)
    {
        $this->companyId=$id;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'XXX domain geography',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Should be: XXX(company) functional domain(eg. manufacturing) geography(eg. Asia)',
                    
                    ),
            ))
            //->add('description', 'ckeditor', array('config_name' => 'user_config'))
            ->add('description')
            ->add('owningcompany')
            ->add('companies', 'entity', array( 
                'required'  => false,
                'class'    => 'TEWTPBundle:Company',
                'multiple' => true,
                'expanded' => false, // checkboxes?
                'attr' => array('class' => 'select2', 'style' => 'width:300px'),
            ))
            ->add('profiles', 'collection', array(
                'label' => 'Positions',
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new CdteProfileType($this->companyId),
                'required' => false,
                'allow_add' => true, // allows to add as many locations as we want
                'allow_delete' => false,
                'by_reference' => false, // 'false' forces setMobilities() to be called
                ))
                ->add('picture', 'sonata_media_type', array(
                'label' => false, // 'label'    =>  'Image'
                'required' => false,
                'provider' => 'sonata.media.provider.image',
                'context'  => 'talentpool',
                'attr' => array('class' => 'span16') // doesn't work
            ))
            //->add('languagesSkills')
            //->add('createdAt') // see __construct()
            //->add('creator') // see __construct()
        ;
            $builder->get('picture')
                ->add('binaryContent', 'file', ['label' => false,])
                ->add('unlink', 'hidden', ['mapped' => false, 'data' => false])// removing the 'unlink' checkbox
                ; 
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEW\TPBundle\Entity\TalentPool'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'talentpool';
    }
}
