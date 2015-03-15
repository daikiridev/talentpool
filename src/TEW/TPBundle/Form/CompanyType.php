<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('active')
            ->add('picture', 'sonata_media_type', array(
                'label' => false, // 'label'    =>  'Image'
                'required' => false,
                'provider' => 'sonata.media.provider.image',
                'context'  => 'company',
                'attr' => array('class' => 'span16') // doesn't work
            ))
            ->add('talentpools', 'entity', array( 
                'required'  => false,
                'class'    => 'TEWTPBundle:TalentPool',
                'multiple' => true,
                'expanded' => false, // checkboxes?
                'attr' => array('class' => 'select2', 'style' => 'width:300px'),
            ))
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
            'data_class' => 'TEW\TPBundle\Entity\Company'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tew_tpbundle_company';
    }
}
