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
        if ($entity instanceof Candidate) { // we store the operation
            $this->storeCdteOperation($em, $entity, CdteOperation::STATUS_CREATE);  
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