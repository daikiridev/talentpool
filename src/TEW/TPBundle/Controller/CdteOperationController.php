<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use TEW\TPBundle\Entity\CdteOperation;
use TEW\TPBundle\Form\CdteOperationType;

/**
 * CdteOperation controller.
 *
 */
class CdteOperationController extends Controller
{

    /**
     * Lists all CdteOperation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TEWTPBundle:CdteOperation')->findAll();

        return $this->render('TEWTPBundle:CdteOperation:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CdteOperation entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CdteOperation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tew_cdteoperation_show', array('id' => $entity->getId())));
        }

        return $this->render('TEWTPBundle:CdteOperation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CdteOperation entity.
     *
     * @param CdteOperation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CdteOperation $entity)
    {
        $form = $this->createForm(new CdteOperationType(), $entity, array(
            'action' => $this->generateUrl('tew_cdteoperation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CdteOperation entity.
     *
     */
    public function newAction()
    {
        $entity = new CdteOperation();
        $form   = $this->createCreateForm($entity);

        return $this->render('TEWTPBundle:CdteOperation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CdteOperation entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:CdteOperation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CdteOperation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:CdteOperation:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CdteOperation entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:CdteOperation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CdteOperation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:CdteOperation:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CdteOperation entity.
    *
    * @param CdteOperation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CdteOperation $entity)
    {
        $form = $this->createForm(new CdteOperationType(), $entity, array(
            'action' => $this->generateUrl('tew_cdteoperation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CdteOperation entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:CdteOperation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CdteOperation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tew_cdteoperation_edit', array('id' => $id)));
        }

        return $this->render('TEWTPBundle:CdteOperation:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CdteOperation entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TEWTPBundle:CdteOperation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CdteOperation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tew_cdteoperation'));
    }

    /**
     * Creates a form to delete a CdteOperation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tew_cdteoperation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete',
                            'attr' => array(
                                'class' => 'btn btn-danger',
                                'onclick' => "if(!confirm('Are you sure? This will definetly erase the operation from the DB!')) { return false; }"
                            )))
            ->getForm()
        ;
    }
}
