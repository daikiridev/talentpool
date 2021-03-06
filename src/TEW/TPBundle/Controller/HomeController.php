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
        $request = $this->getRequest();
        //$talentpools = $em->getRepository('TEWTPBundle:TalentPool')->findAll();
        // We build the form for the talentpool selector
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add('talentpool', 'entity', array(
            'required' => true,
            'label' => false,
            'class' => 'TEWTPBundle:TalentPool',
            'empty_value' => "Choose your working Talent Pool",
            'multiple' => false,
            'expanded' => false
        ));
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $tpid = $request->request->get('form')['talentpool'];
            $form->handleRequest($request);
            if ($form->isValid()) {
                $session = $request->getSession();
                $talentpool = $em->getRepository('TEWTPBundle:TalentPool')->find($tpid);
                $session->set('workingtp', $talentpool);
            }        
        }
        return $this->render('TEWTPBundle:Home:index.html.twig', array(
            'form' => $form->createView(),
        ));
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
