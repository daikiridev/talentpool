<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * CdteLevel controller for service requests
 *
 */
class CdteLevelController extends Controller {

    /**
     * Return the zone associated to a given country
     *
     */
    public function jsonFindAllLevelAction() {
        $request = $this->container->get('request');
        if ($request->isXmlHttpRequest()) {
//        if (true) {
            $response = new JsonResponse();
            $array = $this->getDoctrine()->getEntityManager()->getRepository('TEWTPBundle:CdteLevel')->findAll();
            $array2 = array_merge([['id' => 'null', 'text' => 'Any level']], array_map(function($level){ return ['id' => $level->getId(), 'text' => $level->getName()];}, $array));
            $response->setData(array(
                    'data' => $array2,
                    'query' => "jsonFindAllLevel()"
                    ));
            return $response;
        }
        throw new \Exception('Invalid call');
    }
}
