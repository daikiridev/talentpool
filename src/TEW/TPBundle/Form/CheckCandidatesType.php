<?php
// src/TEW/TPBundle/Form/ModalCollectionType.php
namespace TEW\TPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CheckCandidatesType extends AbstractType
{
    private $cdteIds = null;
    
    public function __construct($entities=null)
    {
        if (count($entities)>0) {
            $cdteIds = [];
            foreach ($entities as $cdte) {
                $this->cdteIds[] = $cdte->getId();
            }
        }
//    print "candidates: ";
//    print_r($this->cdteIds);
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->cdteIds) { // the constructor returned a non empty list (i.e. the list was intialized appart from the handleRequest call)
            $builder->add('candidates', 'entity', array(
                    'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                    'class' => 'TEWTPBundle:Candidate',
                    'required' => true,
                    'expanded' => true,
                    'multiple' => true,
                    'query_builder' => function(\TEW\TPBundle\Entity\CandidateRepository $r) {
                                $qb = $r->createQueryBuilder('c');
                                $qb->where('c.id in (:ids)')
                                          ->setParameter('ids', $this->cdteIds);
//                                print $qb->getQuery()->getDQL().'<br>';
//                                print $qb->getQuery()->getParameters().'<br>';
                                return $qb;
                        }
                    ));
        } else {
            $builder->add('candidates', 'entity', array(
                    'attr' => array('class' => 'form-collection'), // in order to handle jquery functions of tew.candidate.edit.js
                    'class' => 'TEWTPBundle:Candidate',
                    'required' => true,
                    'expanded' => true,
                    'multiple' => true,
                    ));
        }
        $builder
            ->add('selectactions', 'choice', array(
                'empty_value' => 'Select an action',
                'choices' => array('compare' => 'Show selected candidates'),
                'attr' => array('class' => 'form-control'),
            ))
            ->add('submit', 'submit', array(
                'label' => 'Go',
                'attr' => array('class' => 'btn btn-xs btn-info', 'style' => "margin-top: 7px"),
            ))
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
        return 'checkcandidates';
    }
}