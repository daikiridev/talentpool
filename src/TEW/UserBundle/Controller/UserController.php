<?php

namespace TEW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
 
class UserController extends Controller
{
    /**
     * @Template()
     */
    public function whoIsOnlineAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('TEWUserBundle:User')->getActive();
 
        return array('users' => $users);
    }
}