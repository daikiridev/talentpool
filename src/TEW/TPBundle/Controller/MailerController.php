<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TEW\TPBundle\Entity\CdteOperation;
use TEW\TPBundle\Entity\Candidate;

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
    public function mailAction(Request $request)
    {
        $mail_post = $request->request->get('mail_form');
        $response = new JsonResponse();
        $message = \Swift_Message::newInstance()
            ->setSubject($mail_post['object'])
            ->setFrom($mail_post['from'])
            ->setTo($mail_post['to'])
            ->setBody($mail_post['content'])
        ;
        // Is it a request for candidate details?
        $is_cdte_request = isset($mail_post['candidate_details_request']) && $mail_post['candidate_details_request']>0;
        if ($is_cdte_request) {
            $message->setBcc("rlombart@me.com");
        }
        $error = true;
        // send an email in production environment
        if ($this->get('kernel')->getEnvironment() === 'prod') {
            try {
                if ($this->get('mailer')->send($message)==0) { // no delivered message
                    $response->setData(array(
                        'error' => 1,
                        'message' => 'Unable to send mail. Please try again later.'
                    ));
                } else {
                    $error = false;
                    $response->setData(array(
                        'error' => 0,
                        'message' => 'Message/request succesfully sent'
                    ));
                }
            } catch(\Swift_TransportException $e) {
                $response->setData(array(
                    'error' => 1,
                    'message' => 'Unable to send mail ('.$e->getMessage().'). Please try again later.'
                ));
            }
        } else { // this is not the production environment
            $error = false;
            $response->setData(array(
                'error' => 0,
                'message' => 'Message/request not sent in '.$this->get('kernel')->getEnvironment().' environment'
            ));
        }
        if ($is_cdte_request && !$error){ // store the candidate operation "request details" 
            $em = $this->getDoctrine()->getManager();
            $cdteRepository = $em->getRepository('TEWTPBundle:Candidate');
            $cdte = $cdteRepository->find($mail_post['candidate_details_request']);
            $user = $this->getUser();
            $cdteOp = new CdteOperation($user);
            $cdteOp->setCandidate($cdte)
                ->setStatus(CdteOperation::STATUS_ANONYMOUS_DETAILS)
                ->setType(CdteOperation::TYPE_REQUEST)
                ->setRole(implode(', ', $user->getRoles()));
            $em->persist($cdteOp);
//            print $em->getRepository('TEWTPBundle:CdteStatus')->findOneByName('in process'); exit;
            $cdte->setStatus($em->getRepository('TEWTPBundle:CdteStatus')->findOneByName('in process'));
            $em->persist($cdte);
            $em->flush();
        }

        return $response;
    }
}
