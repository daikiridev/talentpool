<?php

namespace TEW\TPBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TalentPoolAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('createdAt')
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
            ->add('name')
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
            //->add('creationDate')
            ->add('name')
            ->add('profiles', 'sonata_type_collection', array('label' => 'Profiles'), array(
                    'class' => 'TEWTPBundle:CdteProfile',
                    'target_entity' => '\TEW\TPBundle\Entity\CdteProfile',
                    'expanded' => false,
                    //'admin_code' => 'sonata.admin.setting',
            ))
            ->add('candidates', 'sonata_type_collection', array('label' => 'Candidates'), array(
                    'class' => 'TEWTPBundle:Candidate',
                    'target_entity' => '\TEW\TPBundle\Entity\Candidate',
                    'expanded' => false,
                    //'admin_code' => 'sonata.admin.setting',
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('createdAt')
            ->add('creator')
            ->add('profiles', 'sonata_type_collection', array('label' => 'Profiles'), array(
                    'class' => 'TEWTPBundle:CdteProfile',
                    'target_entity' => '\TEW\TPBundle\Entity\CdteProfile',
                    'expanded' => false,
                    //'admin_code' => 'sonata.admin.setting',
            ))
            ->add('candidates', 'sonata_type_collection', array('label' => 'Candidates'), array(
                    'class' => 'TEWTPBundle:Candidate',
                    'target_entity' => '\TEW\TPBundle\Entity\Candidate',
                    'expanded' => false,
                    //'admin_code' => 'sonata.admin.setting',
            ))
        ;
    }
}
