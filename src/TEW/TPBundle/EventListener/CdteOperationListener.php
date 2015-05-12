<?php

namespace TEW\TPBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\ORM\Event\LifecycleEventArgs;
use TEW\TPBundle\Entity\Candidate;
use TEW\TPBundle\Entity\CdteOperation;

class CdteOperationListener
{
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function storeCdteOperation($em, $cdte, $status){
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $cdteOp = new CdteOperation($user);
        $cdteOp->setCandidate($cdte)
            ->setStatus($status)
            ->setRole(implode(', ', $user->getRoles()));
        if ('root' === $user->getFullName()) {
            $cdteOp->setType(CdteOperation::TYPE_SYSTEM);
        }
        if (CdteOperation::STATUS_ANONYMOUS_DETAILS === $status) {
            $cdteOp->setType(CdteOperation::TYPE_USER);
        }
        $em->persist($cdteOp);
        $em->flush();
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if ($entity instanceof Candidate) {
            // we store the operation for statistics purposes
            $this->storeCdteOperation($em, $entity, CdteOperation::STATUS_CREATE);
            
            // we then send an email to all users belonging to the candidate's owner
            $userList = $this->container->get('doctrine')->getRepository('TEWUserBundle:User')->findBy(array('company' => $entity->getOwningcompany()));
            $destList = array_map(function($user) {
                return $user->getEmail();
            } , $userList);
            
            $content = "Please visit ".$this->container->get('router')->generate('tew_candidate_show', array('id' => $entity->getId()))." for details";
            
            $securityContext = $this->container->get('security.context');
            $user = $securityContext->getToken()->getUser();
            
            try {
                $message = \Swift_Message::newInstance()
                    ->setSubject("[TEW / Candidate] newly created: $entity ".$entity->getFunction().' '.$entity->getLevel())
                    ->setFrom($user->getEmail())
                    ->setTo($destList)
                    ->setBody($content)
                    ;
    //            var_dump($message); exit;

                $this->container->get('mailer')->send($message);
            } catch(\Swift_TransportException $e) {
                echo "Error while trying to send an informative email to ".  implode(' / ', $destList), $e->getMessage(), "<br>";
            }
        }
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if ($entity instanceof Candidate) { // we store the operation
            $this->storeCdteOperation($em, $entity, CdteOperation::STATUS_EDIT);  
        }
    }
}