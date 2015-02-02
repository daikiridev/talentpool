<?php

namespace TEW\TPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use TEW\TPBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BackEndController extends Controller
{
    /**
     * @Route("/", name="tp_back")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/hello/{name}", name="tp_back_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

}
