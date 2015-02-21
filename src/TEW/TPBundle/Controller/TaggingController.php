<?php

namespace TEW\TPBundle\Controller;

//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * CountryZone controller for service requests
 *
 */
class TaggingController extends Controller {

    /**
     * Return all tags for candidates
     *
     */
    public function jsonFindCandidateTagsAction() {
        $request = $this->container->get('request');
        //if ($request->isXmlHttpRequest()) {
        if (true) {
            $response = new JsonResponse();
            $array = $this->getDoctrine()->getEntityManager()->getRepository('TEWTPBundle:Tagging')->findAllCandidateTags();
            $response->setData($array);
            return $response;
        }
        throw new \Exception('Invalid call');
    }
}
