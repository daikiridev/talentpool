<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SaadTazi\GChartBundle\DataTable;

//use TEW\TPBundle\Entity\TalentPool;

//use SaadTazi\GChartBundle\Chart\PieChart;

/**
 * Candidate controller.
 *
 */
class StatisticsController extends Controller {

    /**
     *
     *
     */
    public function cdteNumberByTalentPoolsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $tps = $em->getRepository('TEWTPBundle:TalentPool')->findAll();
          
        foreach ($tps as $tp) {
            $nb = $em->getRepository('TEWTPBundle:TalentPool')->countCandidatesByTalentPool($tp->getId());
//            $nb=4;
            $rows[] = array(
                array('v' => $tp->getName()),
                array(
                    'v' => $nb,
                    'f' => "$nb candidates"
                    )
                );
        }
        $dataTable1 = new DataTable\DataTable(
                array(
            'cols' =>
            array(
                array(
                    'id' => 'id1',
                    'label' => 'label1',
                    'type' => 'string'
                ),
                array(
                    'id' => 'id2',
                    'label' => 'label2',
                    'type' => 'number'
                )
            ),
            'rows' => $rows
            )
        );
        return $this->render('TEWTPBundle:Statistics:chart.html.twig', array(
                    'title' => '#cdte / talentpool',
                    'chartType' => 'pie',
                    //            'chartType' => 'column',
                    'dataTable1' => $dataTable1->toArray(),
                        //'rawDataTable1' => $dataTable1,
        ));
    }

}
