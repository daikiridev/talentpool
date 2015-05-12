<?php
// src/TEW/TPBundle/Form/ModalCollectionType.php
namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('object', 'hidden')
            ->add('content', 'hidden')
            ->add('from', 'hidden')
            ->add('to', 'hidden')
            ->add('candidate_details_request', 'hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

//    public function getParent()
//    {
//        return 'collection';
//    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'mail_form';
    }
}