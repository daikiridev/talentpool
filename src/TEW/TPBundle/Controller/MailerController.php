<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use TEW\TPBundle\Entity\Mail;
use TEW\TPBundle\Entity\CdteOperation;
use TEW\TPBundle\Entity\CandidateRepository;
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
        try {
            if ($this->get('mailer')->send($message)==0) { // no delivered message
                $response->setData(array(
                    'error' => 1,
                    'message' => 'Unable to send mail. Please try again later.'
                ));
            } else {
                $response->setData(array(
                    'error' => 0,
                    'message' => 'Message/request succesfully sent'
                ));
                if (isset($mail_post['candidate_details_request']) && $mail_post['candidate_details_request']>0){ 
                    $em = $this->getDoctrine()->getManager();
                    $cdteRepository = $em->getRepository('TEWTPBundle:Candidate');
                    $user = $this->getUser();
                    $cdteOp = new CdteOperation($user);
                    $cdteOp->setCandidate($cdteRepository->find($mail_post['candidate_details_request']))
                        ->setStatus(CdteOperation::STATUS_ANONYMOUS_DETAILS)
                        ->setType(CdteOperation::TYPE_REQUEST)
                        ->setRole(implode(', ', $user->getRoles()));
                    $em->persist($cdteOp);
                    $em->flush();
                }
            }
        } catch(\Swift_TransportException $e) {
            $response->setData(array(
                'error' => 1,
                'message' => 'Unable to send mail ('.$e->getMessage().'). Please try again later.'
            ));
        }
        return $response;
    }
}
