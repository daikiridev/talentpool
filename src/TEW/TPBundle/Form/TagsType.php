<?php
namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use DoctrineExtensions\Taggable\TagManager;

class TagsType extends AbstractType
{
    public function __construct(\FPN\TagBundle\Entity\TagManager $tagManager)
    {
        $this->tagManager = $tagManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new TagsTransformer($this->tagManager);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * @return string
     */    
    public function getName()
    {
        return 'tags';
        
    }
}
