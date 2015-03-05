<?php

namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TalentPoolType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('description', 'ckeditor', array('config_name' => 'user_config'))
            ->add('description')
            ->add('profiles', 'collection', array(
                'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                'type' => new CdteProfileType(),
                'required' => false,
                'allow_add' => true, // allows to add as many locations as we want
                'allow_delete' => false,
                'by_reference' => false, // 'false' forces setMobilities() to be called
                ))
            //->add('languagesSkills')
            //->add('createdAt') // see __construct()
            //->add('creator') // see __construct()
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
