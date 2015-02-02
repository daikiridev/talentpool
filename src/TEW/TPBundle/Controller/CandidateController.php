<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use TEW\TPBundle\Entity\Candidate;
use TEW\TPBundle\Form\CandidateType;

/**
 * Candidate controller.
 *
 */
class CandidateController extends Controller
{

    /**
     * Lists all Candidate entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TEWTPBundle:Candidate')->findAll();

        return $this->render('TEWTPBundle:Candidate:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Candidate entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Candidate($this->getUser());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tew_candidate_show', array('id' => $entity->getId())));
        }

        return $this->render('TEWTPBundle:Candidate:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Candidate entity.
     *
     * @param Candidate $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Candidate $entity)
    {
        $form = $this->createForm(new CandidateType(), $entity, array(
            'action' => $this->generateUrl('tew_candidate_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Candidate entity.
     *
     */
    public function newAction()
    {
        $currentUser = $this->getUser();
        if ($currentUser === NULL) { // this should not append...
            return $this->redirect($this->generateUrl('sonata_user_security_login'));
        }        
        $entity = new Candidate($currentUser);
        $form   = $this->createCreateForm($entity);

        return $this->render('TEWTPBundle:Candidate:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Candidate entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:Candidate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidate entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:Candidate:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Candidate entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:Candidate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidate entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:Candidate:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Candidate entity.
    *
    * @param Candidate $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Candidate $entity)
    {
        $form = $this->createForm(new CandidateType(), $entity, array(
            'action' => $this->generateUrl('tew_candidate_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Candidate entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:Candidate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidate entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tew_candidate_edit', array('id' => $id)));
        }

        return $this->render('TEWTPBundle:Candidate:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Candidate entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TEWTPBundle:Candidate')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Candidate entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tew_candidate'));
    }

    /**
     * Creates a form to delete a Candidate entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tew_candidate_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
