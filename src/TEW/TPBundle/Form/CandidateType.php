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
                ->add('picture', 'sonata_media_type', array(
                    'label' => false, // 'label'    =>  'Image'
                    'required' => false,
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'candidate',
                    'attr' => array('class' => 'span16') // doesn't work
                ))
                ->add('gender', 'choice', array(
                    'choices' => array('m' => 'Male', 'f' => 'Female'),
                ))
                ->add('firstName')
                ->add('middleName', 'text', array('required' => false))
                ->add('lastName')
                ->add('dateOfBirth', 'date', array(
                    'years' => range(date('Y')-20, date('Y')-80),
                    'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                    'attr' => array('class' => 'date'), // datepicker when available
                ))
                ->add('email', 'email')
                ->add('phone1')
                ->add('phone2', 'text', array('required' => false))
                ->add('position')
                ->add('targetPositions')
               // ->add('languagesSkills')
                ->add('talentpools')
                ->add('level')
                ->add('origin')
                ->add('tags','tags', array('required' => false, 'attr' => array('class' => 'tags-field input-block-level')))
                ->add('resume', 'sonata_media_type', array(
                    'label' => false,
                    'required' => false,
                    'provider' => 'sonata.media.provider.file',
                    'context'  => 'candidate',
                    'attr' => array('class' => 'span16') // doesn't work
                ))
        //->add('comments')
        //->add("creationDate", "date", array("mapped"=>false))
            ;
        $builder->get('picture')->remove('unlink');
        $builder->get('picture')->add('binaryContent', 'file', [
            'label' => false,
            ]);
       $builder->get('picture')->remove('nimportequoi');
//        $builder
//                ->get('picture')->add('unlink', 'hidden', ['mapped' => false, 'data' => false])
//                ->get('picture')->add('binaryContent', 'file', ['label' => false])
//            ;
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
        return 'tew_tpbundle_candidate';
    }
}
