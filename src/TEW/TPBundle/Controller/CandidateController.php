<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use TEW\TPBundle\Entity\Candidate;
use TEW\TPBundle\Form\CandidateType;
use TEW\TPBundle\Form\CheckCandidatesType;
use TEW\TPBundle\Form\MailType;

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
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entities = $request->request->get('entities');
        
        $tagManager = $this->get('fpn_tag.tag_manager');
  
        // Lists given candidates (result of a search, POST method), otherwise all candidates
        $candidates = $entities?$entities:$em->getRepository('TEWTPBundle:Candidate')->findAll();
        
        foreach ($candidates as $cdte) {
            $tagManager->loadTagging($cdte);
        }
        $deleteForms = array();
        
        $form = $this->createCheckCdtesForm($candidates);
        
        //$form->handleRequest($request);
        
//        if ($form->isValid()) {
//
//        } else {
//            foreach ($candidates as $entity) {
//                $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId(), 'btn-xs')->createView();
//            }
            return $this->render('TEWTPBundle:Candidate:index.html.twig', array(
                        'entities' => $candidates,
                        'check_candidates_form' => $form->createView(),
                        'delete_forms' => $deleteForms,
            ));            
//        }
    }

    /**
     * Creates a form to list all candidates and check them.
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $entities The candidates
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCheckCdtesForm($entities=null) {
        $form = $this->createForm(new CheckCandidatesType(), $entities, array(
            //'action' => $this->generateUrl('tew_candidate_update', array('id' => $entity->getId())),
            'action' => $this->generateUrl('tew_candidate_compare'),
            'method' => 'POST',
        ));

//        $form->add('submit', 'submit', array('label' => 'Update',
//            'attr' => array(
//                'class' => 'btn btn-warning',
//            )
//        ));

        return $form;
    }
    
    /**
     * Compares given candidate entities.
     *
     */
    public function compareAction(Request $request) {
        
       // $entities = $request->get('candidates');
        //var_dump($entities); exit;
        $form = $this->createForm(new CheckCandidatesType());
        $form->handleRequest($request);
        $data = $form->getData();
        $entities = $data['candidates'];
        //var_dump($entities);
        $deleteForms = array();

        if (count($entities)>0) {
            foreach ($entities as $entity) {
                $id = $entity->getId();
                $deleteForms[$id] = $this->createDeleteForm($entity->getId(), 'btn')->createView();
                $mail = new \TEW\TPBundle\Entity\Mail($this->getUser());
                $mail->setObject("[TEW TP] User ".$this->getUser()->getUserName()." (".$this->getUser()->getCompany().") request candidate #$id details");
                $content = $this->generateUrl('tew_candidate_edit', array('id' => $id));
                $mail->setContent($content);
                $mail->setTo("vincent@123vpc.com"); // TO BE CHANGED
                $mailForms[$id] = $this->createMailForm($mail)->createView();
            }
            return $this->render('TEWTPBundle:Candidate:compare.html.twig', array(
                    'entities' => $entities,
                    'delete_forms' => $deleteForms,
                    'mail_forms' => $mailForms,
        ));
        } else {
            return $this->redirect($this->generateUrl('tew_candidate'));
        }
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
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            // here, we can save the candidate, its tags, addresses, etc.
            $em = $this->getDoctrine()->getManager();
// Added by VP ->            
            $formAddresses = $entity->getAddresses();
            // adds new addresses
            if ($formAddresses !== NULL) {
                foreach ($formAddresses as $address) {
                $address->setCandidate($entity);
                $em->persist($address);
                }
            }
            $formComments = $entity->getComments(); 
            // adds new comments
            if ($formComments !== NULL) {
                foreach ($formComments as $comment) {
                    $comment->setCandidate($entity);
                    $comment->setAuthor($this->get('security.context')->getToken()->getUser());
                    $em->persist($comment);
                }
            }
            $formMobilities = $entity->getMobilities();
            // adds new mobility locations
            if ($formMobilities !== NULL) {
                foreach ($formMobilities as $mobility) {
                    $mobility->setCandidate($entity);
                    $em->persist($mobility);
                }
            }
            
            $em->persist($entity);
            $em->flush();
            $tags = $tagManager->loadOrCreateTags($form->get('tags')->getData());
            $tagManager->saveTagging($entity);

            return $this->redirect($this->generateUrl('tew_candidate_show', array('id' => $entity->getId())));
        }

        return $this->render('TEWTPBundle:Candidate:edit_form.html.twig', array(
                    'entity' => $entity,
                    'this_form' => $form->createView(),
                    'operation' => 'creation',
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

        return $this->render('TEWTPBundle:Candidate:edit_form.html.twig', array(
                    'entity' => $entity,
                    'this_form' => $form->createView(),
                    'operation' => 'creation'
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

        // Adding Intl
        //$this->get('twig')->addExtension(new Twig_Extensions_Extension_Intl());
        // Adding tagging stuff - see https://github.com/FabienPennequin/FPNTagBundle
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($entity);
        
        $deleteForm = $this->createDeleteForm($id);
        
        $mail = new \TEW\TPBundle\Entity\Mail($this->getUser());
        $mail->setObject("[TEW TP] User ".$this->getUser()->getUserName()." (".$this->getUser()->getCompany().") request candidate #$id details");
        $content = $this->generateUrl('tew_candidate_edit', array('id' => $entity->getId()));
        $mail->setContent($content);
        $mail->setTo("vincent@123vpc.com"); // TO BE CHANGED
        $mailForm = $this->createMailForm($mail);

        return $this->render('TEWTPBundle:Candidate:show.html.twig', array(
                    'entity' => $entity,
//            'languagesSkills' => $languageRep->findAllSkills(),
//            'languages' => $languageRep->findAllLanguages(),
                    'delete_form' => $deleteForm->createView(),
                    'mail_form' => $mailForm->createView(),
        ));
    }
    
    /**
     * Creates a form to request Candidate's details
     *
     * @param Candidate $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createMailForm(\TEW\TPBundle\Entity\Mail $entity) {
        $form = $this->createForm(new MailType(), $entity, array(
//            'action' => $this->generateUrl('tew_cdtedetails_request', array('id' => $entity->getId(), 'user_id' => $this->getUser()->getId())),
            'action' => $this->generateUrl('tew_cdtedetails_request'),
            'method' => 'POST',
        ));
//        $form->add('submit', 'submit', array('label' => 'Update',
//            'attr' => array(
//                'class' => 'btn btn-warning',
//            )
//        ));

        return $form;
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
        // Adding tagging stuff - see https://github.com/FabienPennequin/FPNTagBundle
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($entity);
        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TEWTPBundle:Candidate:edit_form.html.twig', array(
                    'entity' => $entity,
                    'this_form' => $editForm->createView(),
                    'operation' => 'edit',
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
        // Getting candidate's comments stored in DB
        $originalComments = new ArrayCollection();
        foreach ($entity->getComments() as $comment) {
            $originalComments->add($comment);
        }
        // Getting candidate's mobilities stored in DB
        $originalMobilities = new ArrayCollection();
        foreach ($entity->getMobilities() as $mobility) {
            $originalMobilities->add($mobility);
        }
//        // Getting candidate's languagesSkills stored in DB
//        $originalLanguagesSkills = new ArrayCollection();
//        foreach ($entity->getLanguagesSkills() as $ls) {
//            $originalLanguagesSkills->add($ls);
//        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        // Adding tagging stuff - see https://github.com/FabienPennequin/FPNTagBundle
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tags = $tagManager->loadOrCreateTags($editForm->get('tags')->getData());

        if ($editForm->isValid()) {
// Added by VP ->
            $formAddresses = $entity->getAddresses(); 
            // removes deleted addresses
            foreach ($originalAddresses as $address) {
                if ($formAddresses->contains($address) == false) {
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
            
            $formComments = $entity->getComments(); 
            // removes the relation between comments and the candidate
//            foreach ($originalComments as $comment) {
//                if ($formComments->contains($comment) == false) {
//                    $em->remove($comment);
//                }
//            }
            // adds new comments
            foreach ($formComments as $comment) {
                if ($originalComments->contains($comment) == false) {
                    $comment->setCandidate($entity);
                    $comment->setAuthor($this->get('security.context')->getToken()->getUser());
                    $em->persist($comment);
                }
            }
            
            $formMobilities = $entity->getMobilities();
            // adds new mobility locations
            foreach ($formMobilities as $mobility) {
                if ($originalMobilities->contains($mobility) == false) {
                    $mobility->setCandidate($entity);
                    $em->persist($mobility);
                }
            }  
            
//            $formLanguagesSkills = $entity->getLanguagesSkills();
//            // adds new mobility locations
//            foreach ($formLanguagesSkills as $ls) {
//                if ($originalLanguagesSkills->contains($ls) == false) {
//                    //$ls->setCandidate($entity);
//                    $em->persist($ls);
//                }                
//            }            
// <- Added by VP      
 
            $em->persist($entity);
            $em->flush();
            // after flushing the post, tell the tag manager to actually save the tags
            $tagManager->saveTagging($entity);
            return $this->redirect($this->generateUrl('tew_candidate_show', array('id' => $id)));
        }

        return $this->render('TEWTPBundle:Candidate:edit_form.html.twig', array(
            'entity' => $entity,
            'this_form' => $editForm->createView(),
            'operation' => 'edit',
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
            
            // Delete addresses, comments and media attached to the candidate
            // Ok, not necessary anymore: this is handled by the ORM OneToMany cascade={"persist", "remove"}
//            $addresses = $em->getRepository('TEWTPBundle:Address')->findByCandidate($entity->getId());
//            foreach ($addresses as $address) {
//                $em->remove($address);
//            }
//            $comments = $em->getRepository('TEWTPBundle:CdteComment')->findByCandidate($entity->getId());
//            foreach ($comments as $comment) {
//                $em->remove($comment);
//            }
            // Adding tagging stuff - see https://github.com/FabienPennequin/FPNTagBundle
            $tagManager = $this->get('fpn_tag.tag_manager');
            $tagManager->deleteTagging($entity);

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
    private function createDeleteForm($id, $buttonformat=null) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('tew_candidate_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete',
                            'attr' => array(
                                'class' => "btn btn-danger $buttonformat",
                                'onclick' => "if(!confirm('Are you sure? This will definetly erase the candidate from the DB!')) { return false; }"
                            )
                        ))
                        ->getForm()
        ;
    }

}
