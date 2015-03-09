<?php

namespace TEW\TPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use TEW\TPBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    /**
     * @Route("/", name="tp_home")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $talentpools = $em->getRepository('TEWTPBundle:TalentPool')->findAll();
//        $request = $this->get('request');
//        $session = $request->getSession();
//        $session->set('talentpool', null);
        return array('talentpools' => $talentpools);
        //return $this->redirect($this->generateUrl('tp_home', array('talentpools' => $talentpools)));
    }
    
    /**
     * @Route("/updatetp", name="tp_homeupdatetp")
     * @Template()
     */
    public function updateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
//
        $form = $this->get('form.factory')->create();
        //$form->bind($request);
        if ($request->isMethod('POST')) { 
            $form->submit($request);
//            var_dump($form); exit;
//            echo "id: ".$form->get('id'); exit;
            if ($form->isValid()) { 
                $session = $request->getSession();
                $session->set('talentpool', $em->getRepository('TEWTPBundle:TalentPool')->findById($request->get('id'))); 
            }
        }
        $talentpools = $em->getRepository('TEWTPBundle:TalentPool')->findAll();
        return $this->redirect($this->generateUrl('tp_home', array('talentpools' => $talentpools)));
    }

    /**
     * @Route("/hello/{name}", name="tp_hello")
     * @Template()
     */
    public function echoAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/contact", name="tp_contact")
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

        $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->getFlashBag()->set('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('_tp'));
            }
        }

        return array('form' => $form->createView());
    }
}
