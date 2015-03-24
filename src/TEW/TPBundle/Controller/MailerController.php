<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//use TEW\TPBundle\Entity\Mailer;
//use TEW\TPBundle\Form\MailerType;

/**
 * Mailer controller.
 *
 */
class MailerController extends Controller
{

    /**
     * Lists all Mailer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TEWTPBundle:Mailer')->findAll();

        return $this->render('TEWTPBundle:Mailer:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Mailer entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Mailer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tew_mailer_show', array('id' => $entity->getId())));
        }

        return $this->render('TEWTPBundle:Mailer:edit_form.html.twig', array(
            'entity' => $entity,
            'this_form'   => $form->createView(),
            'operation' => 'creation',
        ));
    }

    /**
     * Creates a form to create a Mailer entity.
     *
     * @param Mailer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Mailer $entity)
    {
        $form = $this->createForm(new MailerType(), $entity, array(
            'action' => $this->generateUrl('tew_mailer_create'),
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
     * Displays a form to create a new Mailer entity.
     *
     */
    public function newAction()
    {
        $entity = new Mailer();
        $form   = $this->createCreateForm($entity);

        return $this->render('TEWTPBundle:Mailer:edit_form.html.twig', array(
            'entity' => $entity,
            'this_form'   => $form->createView(),
            'operation' => 'creation'
        ));
    }

    /**
     * Finds and displays a Mailer entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:Mailer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mailer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:Mailer:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Mailer entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:Mailer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mailer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:Mailer:edit_form.html.twig', array(
            'entity'      => $entity,
            'this_form'   => $editForm->createView(),
            'operation'   => 'edit',
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Mailer entity.
    *
    * @param Mailer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mailer $entity)
    {
        $form = $this->createForm(new MailerType(), $entity, array(
            'action' => $this->generateUrl('tew_mailer_update', array('id' => $entity->getId())),
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
     * Edits an existing Mailer entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:Mailer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mailer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tew_mailer_show', array('id' => $id)));
        }

        return $this->render('TEWTPBundle:Mailer:edit_form.html.twig', array(
            'entity'      => $entity,
            'this_form' => $editForm->createView(),
            'operation' => 'edit',
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Mailer entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TEWTPBundle:Mailer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mailer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tew_mailer'));
    }

    /**
     * Creates a form to delete a Mailer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tew_mailer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete',
                            'attr' => array(
                                'class' => 'btn btn-danger',
                                'onclick' => "if(!confirm('Are you sure? This will definetly erase the candidate from the DB!')) { return false; }"
                            )
                ))
            ->getForm()
        ;
    }
}
