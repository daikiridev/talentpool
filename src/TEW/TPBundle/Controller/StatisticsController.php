<?php

namespace TEW\TPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SaadTazi\GChartBundle\DataTable;


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
                    'label' => '#cdtes',
                    'type' => 'number'
                )
            ),
            'rows' => $rows
            )
        );
        return $this->render('TEWTPBundle:Statistics:chart.html.twig', array(
                    'title' => '#cdtes / talentpool',
                    'chartType' => 'pie',
//                                'chartType' => 'column',
                    'dataTable1' => $dataTable1->toArray(),
                        //'rawDataTable1' => $dataTable1,
        ));
    }

    /**
     *
     *
     */
    public function cdteNumberByStatusByTalentPoolsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $tps = $em->getRepository('TEWTPBundle:TalentPool')->findAll();
        $rows = array();  
        foreach ($tps as $tp) {
            $nb_array = $em->getRepository('TEWTPBundle:TalentPool')->countCandidateStatusByTalentPool($tp->getId());
//            print_r($nb_array);
            // we extract status values from $nb_array and put them into cols labels
            $cols = array_map(
                    function($row){
                        return array('id'=> $row['status'], 'label' => $row['status'], 'type' => 'number'/*, 'color' => $row['color']*/);
                    }, $nb_array);
            // we now compute the rows
            $rowData = array();
            foreach ($nb_array as $nb_row) {
                $rowData[] = $nb_row['nb'];
            }

            $rows[] = array_merge(
                array(array('v' => $tp->getName())),

                array_map(function($nb){
                    return array('v' => $nb, 'f' => "$nb cdte".($nb>1?'s':''));
                }, $rowData)
            );

        }
//                    print_r($rows);
        $dataTable1 = new DataTable\DataTable(
            array(
                'cols' => array_merge( array(array('id'=>'TalentPool', 'label'=>'TalentPool', 'type'=>'string')), $cols),
                'rows' => $rows
            )
        );
        return $this->render('TEWTPBundle:Statistics:chart.html.twig', array(
                    'title' => '#cdtes / status / talentpool',
//                    'chartType' => 'pie',
                                'chartType' => 'column',
                    'dataTable1' => $dataTable1->toArray(),
                        //'rawDataTable1' => $dataTable1,
        ));
    }    
}
