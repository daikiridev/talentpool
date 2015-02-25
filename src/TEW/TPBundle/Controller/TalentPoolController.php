<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

use TEW\TPBundle\Entity\TalentPool;
use TEW\TPBundle\Form\TalentPoolType;

/**
 * TalentPool controller.
 *
 */
class TalentPoolController extends Controller
{

    /**
     * Lists all TalentPool entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TEWTPBundle:TalentPool')->findAll();

        return $this->render('TEWTPBundle:TalentPool:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TalentPool entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TalentPool($this->getUser());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
// Added by VP ->            
            $formProfiles = $entity->getProfiles();
            // adds new profiles
            if ($formProfiles !== NULL) {
                foreach ($formProfiles as $profile) {
                $profile->setTalentpool($entity);
                $em->persist($profile);
                }
            }
//  <- Added by VP
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tew_talentpool_show', array('id' => $entity->getId())));
        }

        return $this->render('TEWTPBundle:TalentPool:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TalentPool entity.
     *
     * @param TalentPool $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TalentPool $entity)
    {
        $form = $this->createForm(new TalentPoolType(), $entity, array(
            'action' => $this->generateUrl('tew_talentpool_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 
                                            'attr' => array(
                                                'class' => 'btn btn-warning',
                                            )
                    ));

        return $form;
    }

    /**
     * Displays a form to create a new TalentPool entity.
     *
     */
    public function newAction()
    {
        $currentUser = $this->getUser();
        if ($currentUser === NULL) { // this should not append...
            return $this->redirect($this->generateUrl('sonata_user_security_login'));
        }
        $entity = new TalentPool($currentUser);
        $form   = $this->createCreateForm($entity);

        return $this->render('TEWTPBundle:TalentPool:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TalentPool entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:TalentPool')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TalentPool entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:TalentPool:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TalentPool entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:TalentPool')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TalentPool entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:TalentPool:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TalentPool entity.
    *
    * @param TalentPool $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TalentPool $entity)
    {
        $form = $this->createForm(new TalentPoolType(), $entity, array(
            'action' => $this->generateUrl('tew_talentpool_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 
                                            'attr' => array(
                                                'class' => 'btn btn-warning',
                                            )
                    ));

        return $form;
    }
    /**
     * Edits an existing TalentPool entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:TalentPool')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TalentPool entity.');
        }
// Added by VP ->        
        // Getting talentpool's profiles stored in DB
        $originalProfiles = new ArrayCollection();
        foreach ($entity->getProfiles() as $profile) {
            $originalProfiles->add($profile);
        }
//  <- Added by VP
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
// Added by VP ->          
            $formProfiles = $entity->getProfiles();
            // removes the relation between profiles and the candidate
            foreach ($originalProfiles as $profile) {
                if ($formProfiles->contains($profile) == false) {
                    $em->remove($profile);
                }
            }
            // adds new profiles
            foreach ($formProfiles as $profile) {
                if ($originalProfiles->contains($profile) == false) {
                    $profile->setTalentpool($entity);
                    $em->persist($profile);
                }
            }
//  <- Added by VP
            $em->flush();

            return $this->redirect($this->generateUrl('tew_talentpool_show', array('id' => $id)));
        }

        return $this->render('TEWTPBundle:TalentPool:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TalentPool entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TEWTPBundle:TalentPool')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TalentPool entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tew_talentpool'));
    }

    /**
     * Creates a form to delete a TalentPool entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tew_talentpool_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 
                                        'attr' => array(
                                            'class' => 'btn btn-danger',
                                            'onclick' => "if(!confirm('Are you sure?')) { return false; }"
                                            )
                ))
            ->getForm()
        ;
    }
}
