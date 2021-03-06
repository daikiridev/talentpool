<?php

namespace TEW\TPBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\ORM\Event\LifecycleEventArgs;
use TEW\TPBundle\Entity\Candidate;
use TEW\TPBundle\Entity\CdteComment;
use TEW\TPBundle\Entity\CdteOperation;

class CdteOperationListener
{
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function storeCdteOperation($em, $cdte, $status){
        // WARNING: when launching any operation as a webservice, the security context is lost!
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $cdteOp = new CdteOperation($user);
        $cdteOp->setCandidate($cdte)
            ->setStatus($status)
            ->setRole(implode(', ', $user->getRoles()));
        if ('root' === $user->getFullName()) {
            $cdteOp->setType(CdteOperation::TYPE_SYSTEM);
        }
        switch($status) {
            case CdteOperation::STATUS_ANONYMOUS_DETAILS:  
                $cdte->setStatus($em->getRepository('TEWTPBundle:CdteStatus')->findOneByName('in process'));
                $em->persist($cdte);
            case CdteOperation::STATUS_COMMENT:
                $cdteOp->setType(CdteOperation::TYPE_USER);
        }
        
        $em->persist($cdteOp);
        $em->flush();
    }

    // Whenever an object is persisted in DB...
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
            
            $securityContext = $this->container->get('security.context');
            $user = $securityContext->getToken()->getUser();
            
            $context = $this->container->get('router')->getContext();
            $url = $context->getScheme().'://';
            $url .= $context->getHost().':';
            $url .= $context->getScheme()==='https'?$context->getHttpsPort():$context->getHttpPort() ;
            $url .= $this->container->get('router')->generate('tew_candidate_show', array('id' => $entity->getId()));
            $content = "Please visit $url for details\n\n";
            $content.= "Candidate created by ".$user->getUsername()." (".$user->getCompany().") on ".$entity->getCreatedAt()->format('Y-m-d H:i:s');
            
            try {
                $message = \Swift_Message::newInstance()
                    ->setSubject("[TEW / Cdte] newly created: $entity ".$entity->getFunction().' '.$entity->getLevel())
                    ->setFrom($user->getEmail())
                    ->setTo($destList)
                    ->setBody($content)
                    ;
    //            var_dump($message); exit;

                $this->container->get('mailer')->send($message);
            } catch(\Swift_TransportException $e) {
                echo "Error while trying to send an informative email to ".  implode(' / ', $destList), $e->getMessage(), "<br>";
            }
        } elseif ($entity instanceof CdteComment) {
            // we store the operation for statistics purposes
            $this->storeCdteOperation($em, $entity->getCandidate(), CdteOperation::STATUS_COMMENT);
        }
    }
    
    // Whenever there is a DB update...
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if ($entity instanceof Candidate) { // we store the operation
            $this->storeCdteOperation($em, $entity, CdteOperation::STATUS_EDIT);  
        }
    }
}