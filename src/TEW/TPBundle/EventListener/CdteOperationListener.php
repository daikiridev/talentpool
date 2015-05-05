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
    
    public function storeCdteOperation($em, $cdte, $user, $status){
        $cdteOp = new CdteOperation($user);
        $cdteOp->setCandidate($cdte);
        $cdteOp->setStatus($status);
        $cdteOp->setRole(implode(', ', $user->getRoles()));
        $em->persist($cdteOp);
        $em->flush();
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $securityContext = $this->container->get('security.context');

        if ($entity instanceof Candidate) { // we store the operation
            $this->storeCdteOperation($em, $entity, $securityContext->getToken()->getUser(), CdteOperation::STATUS_CREATE);  
        }
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $securityContext = $this->container->get('security.context');

        if ($entity instanceof Candidate) { // we store the operation
            $this->storeCdteOperation($em, $entity, $securityContext->getToken()->getUser(), CdteOperation::STATUS_EDIT);  
        }
    }
}