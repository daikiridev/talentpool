<?php
// src/TEW/TPBundle/Form/ModalCollectionType.php
namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModalCollectionType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'modalcollection';
    }
}