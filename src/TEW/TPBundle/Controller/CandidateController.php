<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use TEW\TPBundle\Entity\Candidate;
use TEW\TPBundle\Form\CandidateType;

/**
 * Candidate controller.
 *
 */
class CandidateController extends Controller {

    /**
     * Search 
     *
     */
    public function searchAction() {
        return $this->render('TEWTPBundle:Candidate:search.html.twig', array(
        ));
    }

    /**
     * Lists all Candidate entities.
     *
     */
    public function indexAction() {
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
    public function createAction(Request $request) {
        $entity = new Candidate($this->getUser());
        $form = $this->createCreateForm($entity);

        // Adding tagging stuff - see https://github.com/FabienPennequin/FPNTagBundle
        $tagManager = $this->get('fpn_tag.tag_manager');

//        // ask the tag manager to create a Tag object
//        $fooTag = $tagManager->loadOrCreateTag('foo');
//
//        // assign the foo tag to the post
//        $tagManager->addTag($fooTag, $entity);
        

        $form->handleRequest($request);

        if ($form->isValid()) {
            // here, we can save the candidate, its tags, addresses, etc.
            $em = $this->getDoctrine()->getManager();
            
            // Ajout de code pour la sauvegarde des addresses
            
            
            
            $tagManager->saveTagging($entity);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tew_candidate_show', array('id' => $entity->getId())));
        }

        return $this->render('TEWTPBundle:Candidate:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Candidate entity.
     *
     * @param Candidate $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Candidate $entity) {
        $form = $this->createForm(new CandidateType(), $entity, array(
            'action' => $this->generateUrl('tew_candidate_create'),
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
     * Displays a form to create a new Candidate entity.
     *
     */
    public function newAction(Request $request) {
        $currentUser = $this->getUser();
        if ($currentUser === NULL) { // this should not append...
            return $this->redirect($this->generateUrl('sonata_user_security_login'));
        }
        $entity = new Candidate($currentUser);
        $form = $this->createCreateForm($entity);

        return $this->render('TEWTPBundle:Candidate:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Candidate entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $languageRep = $em->getRepository('TEWTPBundle:CdteLanguage');

        $entity = $em->getRepository('TEWTPBundle:Candidate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidate entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:Candidate:show.html.twig', array(
                    'entity' => $entity,
//            'languagesSkills' => $languageRep->findAllSkills(),
//            'languages' => $languageRep->findAllLanguages(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Candidate entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:Candidate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidate entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $this->get('fpn_tag.tag_manager')->saveTagging($entity); // to be confirmed...

        return $this->render('TEWTPBundle:Candidate:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
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
    private function createEditForm(Candidate $entity) {
        $form = $this->createForm(new CandidateType(), $entity, array(
            'action' => $this->generateUrl('tew_candidate_update', array('id' => $entity->getId())),
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
     * Edits an existing Candidate entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TEWTPBundle:Candidate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidate entity.');
        }
        // Getting candidate's addresses stored in DB
        $originalAddresses = new ArrayCollection();
        foreach ($entity->getAddresses() as $address) {
            $originalAddresses->add($address);
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        // Adding tagging stuff - see https://github.com/FabienPennequin/FPNTagBundle
        $tagManager = $this->get('fpn_tag.tag_manager');

        if ($editForm->isValid()) {
            // Added by VP ->
            $formAddresses = $entity->getAddresses(); 
                // removes the relation between addresses and the candidate
                foreach ($originalAddresses as $address) {
                    if ($formAddresses->contains($address) == false) {
                        // In case of ManyToMany relation:
                        // $address->getCandidates()->removeElement($address);
                        // $em->persist($address);

                        // In case of ManyToOne relation:
                        $em->remove($address);
                    }
                }
                // adds new addresses
                foreach ($formAddresses as $address) {
                    if ($originalAddresses->contains($address) == false) {
                        $address->setCandidate($entity);
                        $em->persist($address);
                    }
                }
            // <- Added by VP

            $tagManager->saveTagging($entity);
                        
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tew_candidate_edit', array('id' => $id)));
        }

        return $this->render('TEWTPBundle:Candidate:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Candidate entity.
     *
     */
    public function deleteAction(Request $request, $id) {
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
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('tew_candidate_delete', array('id' => $id)))
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
