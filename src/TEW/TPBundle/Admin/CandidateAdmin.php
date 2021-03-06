<?php

namespace TEW\TPBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CandidateAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            //->add('scoreAverage') // computed field, cannot be added to the filters
            ->add('gender')
            ->add('firstName')
            ->add('middleName')
            ->add('lastName')
            
            //->add('dateOfBirth')
            //->add('email')
            //->add('phone1')
            //->add('phone2')
            //->add('level')
            //->add('creationDate')
            ->add('creator')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('gender')
            ->add('firstName')
            ->add('middleName')
            ->add('lastName')
            ->add('function')
            ->add('level')
            ->add('scoreAverage')
            //->add('dateOfBirth')
            //->add('email')
            //->add('phone1')
            //->add('phone2')
            //->add('level')
            //->add('creationDate')
            ->add('creator')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                //->add('id')
                ->add('picture', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'candidate')))
                ->add('gender')
                ->add('firstName')
                ->add('middleName')
                ->add('lastName')
                ->add('dateOfBirth')
                ->add('email')
                ->add('phone1')
                ->add('phone2')
                ->add('function')
                ->add('level')
                ->add('languagesSkills')
                ->add('targetFunction1')
                ->add('targetLevel1')
                ->add('targetFunction2')
                ->add('targetLevel2')
                ->add('targetFunction3')
                ->add('targetLevel3')                
                ->add('talentpools')
                ->add('mobilities')
                ->add('comments')
//                ->add('creationDate')
//                ->add('creator')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('gender')
                ->add('firstName')
                ->add('middleName')
                ->add('lastName')
                ->add('dateOfBirth')
                ->add('email')
                ->add('phone1')
                ->add('phone2')
                ->add('function')
                ->add('level')
                ->add('languagesSkills')
                ->add('targetFunction1')
                ->add('targetLevel1')
                ->add('targetFunction2')
                ->add('targetLevel2')
                ->add('targetFunction3')
                ->add('targetLevel3')                
                ->add('talentpools')
                ->add('mobilities')
                ->add('comments')
                ->add('scoreAverage')
                ->add('creationDate')
                ->add('creator')
        ;
    }
}
