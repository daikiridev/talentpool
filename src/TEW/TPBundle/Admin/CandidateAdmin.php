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
                ->add('id')
                ->add('gender')
                ->add('firstName')
                ->add('middleName')
                ->add('lastName')
                ->add('dateOfBirth')
                ->add('email')
                ->add('phone1')
                ->add('phone2')
                ->add('picture', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'candidate')))
                ->add('level')
                ->add('position')
                ->add('targetPositions')
                ->add('talentpools')
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
                ->add('level')
                ->add('position')
                ->add('targetPositions')
                ->add('talentpools')
                ->add('comments')
                ->add('scoreAverage')
                ->add('creationDate')
                ->add('creator')
        ;
    }
}
