<?php

namespace TEW\TPBundle\Controller;

//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use TEW\TPBundle\Entity\CountryZone;

/**
 * CountryZone controller for service requests
 *
 */
class CountryZoneController extends Controller {

    /**
     * Return the zone associated to a given country
     *
     */
    public function jsonFindZoneByCountryAction() {
        $request = $this->container->get('request');
        $id = $request->request->get('country');
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            if ($id != '') {
                $array = $this->getDoctrine()->getEntityManager()->getRepository('TEWTPBundle:Zone')->findZoneByCountry($id);
                //$array = $this->getDoctrine()->getEntityManager()->getRepository('TEWTPBundle:Zone')->findOneByCountry($id);
                $response->setData(array(
                    'zone' => $array,
                    'query' => "findZoneByCountry($id)"
                ));
            }
            return $response;
        }
        throw new \Exception('Invalid call');
    }
}
