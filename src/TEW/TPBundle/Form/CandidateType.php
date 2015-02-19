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
                // ->add('addresses')
                ->add('addresses', 'collection', array(
                    'attr' => array('class' => 'form-collection'), // in order to handle the jquery functions
                    'type' => new AddressType(),
                    'required' => false,
                    'allow_add' => true, // allows to add as many addresses as we want
                    'allow_delete' => true,
                    'by_reference' => false, // 'false' forces setAddresses() to be called
                    ))
                // changing position's label
                ->add('position', 'entity', array(
                    'class' => 'TEWTPBundle:CdtePosition',
                    'label' => 'Current position',
                    'empty_value' => 'Select'
                    ))
                ->add('level', 'choice', array(
                    'label' => 'Experience',
                    'choices' => range(0,40),
                    'empty_value'=> 'Yrs')
                    )
                ->add('annualIncome')
                ->add('targetPosition1')
                ->add('targetPosition2')
                ->add('targetPosition3')
                //->add('targetPositions')
                ->add('mobilities', 'collection', array(
                    'attr' => array('class' => 'form-collection'), // in order to handle the jquery functions
                    'type' => new CdteMobilityType(),
                    'required' => false,
                    'allow_add' => true, // allows to add as many comments as we want
                    'allow_delete' => false,
                    'by_reference' => false, // 'false' forces setComments() to be called
                    ))
                ->add('languagesSkills')
//                ->add('languagesSkills', 'collection', array('type'=>new CdteLanguageType)) // we change the default form
                ->add('talentpools')
                ->add('origin')
//                ->add('tags')
                ->add('tags','tags', array('required' => false, 'attr' => array('class' => 'tags-field input-block-level')))
                ->add('resume', 'sonata_media_type', array(
                    'label' => false,
                    'required' => false,
                    'provider' => 'sonata.media.provider.file',
                    'context'  => 'candidate',
                    'attr' => array('class' => 'span16') // doesn't work
                ))
                //->add('comments')
                ->add('comments', 'collection', array(
                    'attr' => array('class' => 'form-collection'), // in order to handle the jquery functions
                    'type' => new CdteCommentType(),
                    'required' => false,
                    'allow_add' => true, // allows to add as many comments as we want
                    'allow_delete' => false,
                    'by_reference' => false, // 'false' forces setComments() to be called
                    ))
            ;
        //$builder->get('picture')->remove('unlink');
        $builder->get('picture')->add('binaryContent', 'file', ['label' => false,]);
        //$builder->get('resume')->remove('unlink');
        $builder->get('resume')->add('binaryContent', 'file', ['label' => false,]);
        
//        

//       $builder->get('picture')->remove('nimportequoi');
////        $builder
////                ->get('picture')->add('unlink', 'hidden', ['mapped' => false, 'data' => false])
////                ->get('picture')->add('binaryContent', 'file', ['label' => false])
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
        return 'candidate';
    }
}
