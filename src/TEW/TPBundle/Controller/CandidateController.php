<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use TEW\TPBundle\Entity\Candidate;
use TEW\TPBundle\Form\CandidateType;
use TEW\TPBundle\Form\CdteSearchType;
use TEW\TPBundle\Form\CheckCandidatesType;
use TEW\TPBundle\Entity\Mail;
use TEW\TPBundle\Form\MailType;
//use TEW\UserBundle\Entity\User;

/**
 * Candidate controller.
 *
 */
class CandidateController extends Controller {


    /**
     * Lists all Candidate entities.
     *
     */
    public function indexAction(Request $request, $entities=null) {
        $em = $this->getDoctrine()->getManager();
        //$entities = $request->request->get('entities');
        $tagManager = $this->get('fpn_tag.tag_manager');
  
        // Lists given candidates (result of a search, POST method), otherwise all candidates
        $candidates = $entities?$entities:$em->getRepository('TEWTPBundle:Candidate')->findAll();
        
        foreach ($candidates as $cdte) {
            $tagManager->loadTagging($cdte);
        }
        
        $form = $this->createCheckCdtesForm($candidates);
        $form->handleRequest($request);
        
        if ($form->isValid()){
            return $this->render('TEWTPBundle:Candidate:index.html.twig', array(
                        'entities' => $candidates,
                        'check_candidates_form' => $form->createView(),
            ));            
        } else { // either select action is invalid or we come from a search request
            return $this->render('TEWTPBundle:Candidate:index.html.twig', array(
                        'entities' => $candidates,
                        'check_candidates_form' => $form->createView(),
                        'fromSearch'=>false,
            ));            
        } 
    }
    
    /**
     * Search form on candidates
     *
     */
    public function cdteSearchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new CdteSearchType());
        $form->handleRequest($request);
        $deleteForms = array();
        if ($form->isValid()){
            $data = $form->getData('cdtesearch');
            $repository = $em->getRepository('TEWTPBundle:Candidate');
            $qb = $repository->createQueryBuilder('c')->where('1=1');
            $qb->orderBy('c.alert', 'DESC');
            $qb->addOrderBy('c.globalScore', 'DESC');
            $filterDetails = array();
            
            foreach($data as $key => $value) {
                switch ($key) {
                    case 'invisible':
                        if ($value==1) {
                            $qb->andWhere("c.active = :$key")->setParameter($key, 0);
                            $filterDetails['invisible'] = 'yes';
                        }
                        break;
                    case 'alert':
                    case 'function':
                    case 'level':
                    case 'owningcompany':
                        if ($value !='') {
                            $qb->andWhere("c.$key = :$key")->setParameter($key, $value);
                            $filterDetails[$key] = gettype($value)=='object'?$value->getName():$value;
                        }
                        break;
                    case 'experience':
                        if ($value !='') {
                            $qb->andWhere('c.experience < :year')->setParameter('year', date('Y')-$value);
                            $filterDetails[$key] = '> '.(date('Y')-$value);
                        }
                        break;
                    case 'status':
                        if (count($value)>0) {
                            foreach($value as $status) {
                                $statuses[] = $status->getId();
                            }
                            $qb->andWhere('c.status IN (:ids)')->setParameter('ids', $statuses);
                            $filterDetails[$key] = ' in ('.implode(', ',$statuses).')';
                        }
                        break;
                }   
            }
            // we add access restrictions
            // ...
            $query = $qb->getQuery();
//            print $query->getDQL().'<br>';
//            print $query->getSQL().'<br>';
//            print_r($query->getArrayResult());
            $candidates = $query->getResult();
            //print "nb candidates=".count($candidates).'<br>';
            // We load tags of all candidates
            $tagManager = $this->get('fpn_tag.tag_manager');
            foreach ($candidates as $cdte) {
                $tagManager->loadTagging($cdte);
            }
            $checkform = $this->createCheckCdtesForm($candidates);
            //$checkform->handleRequest($request);

            return $this->render('TEWTPBundle:Candidate:index.html.twig', array(
                        'entities' => $candidates,
                        'check_candidates_form' => $checkform->createView(),
                        'delete_forms' => $deleteForms,
                        'filter_details' => $filterDetails,
            ));
//            return $this->forward('TEWTPBundle:Candidate:index', array(
//                'entities' => $candidates,
//                'filter_details' => $filterDetails,
//            ));
        } else {
            return $this->render('TEWTPBundle:Candidate:search.html.twig', array(
                        'this_form' => $form->createView(),
//                        'entities' => $entities,
//                        'delete_forms' => $deleteForms,
            ));
        }
    }
    
    /**
     * Anonymous search form on candidates (webservice call)
     *
     */
    public function jsonCdteAnonSearchAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TEWTPBundle:Candidate');
        
        $request = $this->container->get('request');
        if ($request->getMethod()==='POST') {
            $level = $request->request->get('level');
            $function = $request->request->get('function');
        } else {
            $level = $request->query->get('level');
            $function = $request->query->get('function');
        }
        
//        print("level: $level. function: $function. <br>");
        if ($request->isXmlHttpRequest()) {
        //if (true) {
            $response = new JsonResponse();
            $qb = $repository->createQueryBuilder('c')->where('1=1')
                //->select(array('c.level', 'c.function', 'c.experience', 'c.nationality1', 'c.globalScore'))
                ->select(array('c.globalComment', 'c.globalScore', 'c.experience', 'c.nationality1'))
//                ->select(array('c.experience', 'c.nationality1'))
                ->orderBy('c.globalScore', 'DESC');
            
            if ($level != '' && $level !='null') {
                $qb->andWhere("c.level = :level OR c.targetLevel1 = :level OR c.targetLevel2 = :level OR c.targetLevel2 = :level")
                        ->setParameter('level', $level)
                    ;                ;
            }
            if ($function != '' && $function != 'null') {
                $qb->andWhere("c.function = :function OR c.targetFunction1 = :function OR c.targetFunction2 = :function OR c.targetFunction2 = :function")
                        ->setParameter('function', $function)
                    ;
            }
            $query = $qb->getQuery();
            $candidates = $query->getResult();
            
            /* TODO:
             * - set empty value in level and function select2
             * - apply star twig filter to scores
             * - set comments as bootstrap popovers on global scores
             */
            
            $response->setData(array(
                'data' => $candidates,
                //'query' => "cdteAnonSearchAction(level: $level, function: $function)"
            ));
            return $response;
//            $serializedEntity = $this->container->get('serializer')->serialize($candidates, 'json');
//            $response->headers->set('Content-Type', 'application/json');
//            return new Response($serializedEntity);
        }
        throw new \Exception('Invalid call');

    }
    
    /**
     * Creates a form to list all candidates and check them.
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $entities The candidates
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCheckCdtesForm($entities=null) {
        //$form = $this->createForm(new CheckCandidatesType(), $entities, array(
        $form = $this->createForm(new CheckCandidatesType($entities), $entities, array(
            //'action' => $this->generateUrl('tew_candidate_update', array('id' => $entity->getId())),
            'action' => $this->generateUrl('tew_candidate_compare'),
            'method' => 'POST',
        ));
        return $form;
    }
    
    /**
     * Compares given candidate entities.
     *
     */
    public function compareAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new CheckCandidatesType(null));
        $form->handleRequest($request);
        $form->isValid();
        $data = $form->getData();
        //exit;
        $entities = $data['candidates'];

        $deleteForms = array();

        if (count($entities)>0) {
            $tagManager = $this->get('fpn_tag.tag_manager');
            foreach ($entities as $entity) {
                $id = $entity->getId();
                $tagManager->loadTagging($entity);
                $deleteForms[$id] = $this->createDeleteForm($entity->getId(), 'btn')->createView();
                $mail = new Mail($this->getUser(), $em->getRepository('TEWUserBundle:User')->findOneByUsername('admin'));
                $mail->setObject("[TEW TP] User ".$this->getUser()->getUserName()." (".$this->getUser()->getCompany().") requests candidate #$id details");
                
                $content = $this->getRequest()->server->get('HTTPS')?'https://':'http://';
                $content .= $this->getRequest()->server->get('SERVER_NAME').':'.$this->getRequest()->server->get('SERVER_PORT');
                $content .= $this->generateUrl('tew_candidate_edit', array('id' => $id));

                $mail->setContent($content);
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

        // Is the user allowed to perform such action?
        if (!($this->get('security.context')->isGranted('ROLE_TEW_OBJECT_CREATE'))) {
            throw new AccessDeniedException('Access Denied');
        }        
        
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
       // Is the user allowed to perform such action?
        if (!($this->get('security.context')->isGranted('ROLE_TEW_OBJECT_CREATE'))) {
            throw new AccessDeniedException('Access Denied');
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
        //$languageRep = $em->getRepository('TEWTPBundle:CdteLanguage');

        $entity = $em->getRepository('TEWTPBundle:Candidate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidate entity.');
        }
        
//        // Is the user allowed to perform such action?
//        if (!($this->get('security.context')->isGranted('ROLE_TEW_OBJECT_VIEW', $entity) ||
//                $this->get('security.context')->isGranted('ROLE_TEW_STD_EXECUTOR'))) {
//            throw new AccessDeniedException('Access Denied');
//        }
        $deleteAccess = $this->get('security.context')->isGranted('ROLE_TEW_OBJECT_DELETE', $entity) ||
                        $this->get('security.context')->isGranted('ROLE_MASTER_EXECUTOR');
        $deleteFormView = $deleteAccess?$this->createDeleteForm($id)->createView():null;

        // Adding Intl
        //$this->get('twig')->addExtension(new Twig_Extensions_Extension_Intl());
        // Adding tagging stuff - see https://github.com/FabienPennequin/FPNTagBundle
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($entity);
        
        $mail = new Mail($this->getUser(), $em->getRepository('TEWUserBundle:User')->findOneByUsername('admin'));
        $mail->setObject("[TEW TP] User ".$this->getUser()->getUserName()." (".$this->getUser()->getCompany().") requests candidate #$id details");
        $content = $this->getRequest()->server->get('HTTPS')?'https://':'http://';
        $content .= $this->getRequest()->server->get('SERVER_NAME').':'.$this->getRequest()->server->get('SERVER_PORT');
        $content .= $this->generateUrl('tew_candidate_edit', array('id' => $entity->getId()));
        $mail->setContent($content);
        $mailForm = $this->createMailForm($mail);

        return $this->render('TEWTPBundle:Candidate:show.html.twig', array(
                    'entity' => $entity,
//            'languagesSkills' => $languageRep->findAllSkills(),
//            'languages' => $languageRep->findAllLanguages(),
                    'delete_form' => $deleteFormView,
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
        
        // Is the user allowed to perform such action?
        if (!($this->get('security.context')->isGranted('ROLE_TEW_OBJECT_EDIT', $entity) ||
              $this->get('security.context')->isGranted('ROLE_MASTER_EXECUTOR'))) {
            throw new AccessDeniedException('Access Denied');
        }
        $editForm = $this->createEditForm($entity);
        $deleteAccess = $this->get('security.context')->isGranted('ROLE_TEW_OBJECT_DELETE', $entity) ||
                        $this->get('security.context')->isGranted('ROLE_MASTER_EXECUTOR');
        $deleteFormView = $deleteAccess?$this->createDeleteForm($id)->createView():null;
        
        // Adding tagging stuff - see https://github.com/FabienPennequin/FPNTagBundle
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($entity);

        return $this->render('TEWTPBundle:Candidate:edit_form.html.twig', array(
                    'entity' => $entity,
                    'this_form' => $editForm->createView(),
                    'operation' => 'edit',
                    'delete_form' => $deleteFormView,
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
            // Is the user allowed to perform such action?
            if (!($this->get('security.context')->isGranted('ROLE_TEW_OBJECT_DELETE', $entity) ||
                  $this->get('security.context')->isGranted('ROLE_MASTER_EXECUTOR'))) {
                throw new AccessDeniedException('Access Denied');
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
