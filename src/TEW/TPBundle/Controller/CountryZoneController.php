<?php

namespace TEW\TPBundle\Controller;

//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TEW\TPBundle\Entity\CountryZone;

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
        //if (true) {
            $response = new JsonResponse();

            $em = $this->container->get('doctrine')->getManager();

            if ($id != '') {
                $qb = $em->createQueryBuilder('zc')
                    ->select('z.id', 'z.fullname')
                    ->from('TEWTPBundle:CountryZone', 'zc')
                    ->join('TEWTPBundle:Zone', 'z') // we can't directly select zc.zone, since it is related to a ManyToOne join
                    ->where("zc.country = :country")
                    ->andWhere('zc.zone = z.id')
                    ->setParameter('country', $id);

                $query = $qb->getQuery();
                $response->setData(array('zone' => $query->getResult(), 'query' => $qb->getDql()));
//            } else {
//                $response->setData(array());
            }
            return $response;
        }
        throw new \Exception('Invalid call'); 
    }

}
