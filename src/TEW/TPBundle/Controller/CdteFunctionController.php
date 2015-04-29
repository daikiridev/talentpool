<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * CdteFunction controller for service requests
 *
 */
class CdteFunctionController extends Controller {

    /**
     * Return the zone associated to a given country
     *
     */
    public function jsonFindAllFunctionAction() {
        $request = $this->container->get('request');
        if ($request->isXmlHttpRequest()) {
//        if (true) {
            $response = new JsonResponse();
            $array = $this->getDoctrine()->getEntityManager()->getRepository('TEWTPBundle:CdteFunction')->findAll();
            $array2 = array_merge([['id' => 'null', 'text' => 'Any function']], array_map(function($function){ return ['id' => $function->getId(), 'text' => $function->getName()];}, $array));
            $response->setData(array(
                    'data' => $array2,
                    'query' => "jsonFindAllFunction()"
                    ));
            return $response;
        }
        throw new \Exception('Invalid call');
    }
}
