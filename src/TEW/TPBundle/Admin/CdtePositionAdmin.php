<?php

namespace TEW\TPBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CdtePositionAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
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
            // ->add('id')
            ->add('name')
            ->add('level') // same as ->add('level', 'entity', array('class' => 'TEWTPBundle:CdteLevel'))
            ->add('function') // same as ->add('function', 'entity', array('class'=>'TEWTPBundle:CdteFunction'))
            ->add('function', 'entity', array('class'=>'TEWTPBundle:CdteFunction'))
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
            ->add('level') // same as ->add('level', 'entity', array('class' => 'TEWTPBundle:CdteLevel'))
            ->add('function') // same as ->add('function', 'entity', array('class'=>'TEWTPBundle:CdteFunction'))
            ->add('talentpools', 'sonata_type_collection', array('label' => 'Talent pools'), array(
                    'class' => 'TEWTPBundle:TalentPool',
                    'target_entity' => '\TEW\TPBundle\Entity\TalentPool',
                    'expanded' => false,
                    //'admin_code' => 'sonata.admin.setting',
                )
            )
        ;
    }
}
