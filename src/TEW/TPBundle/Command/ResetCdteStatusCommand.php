<?php

// src/TEW/TPBundle/Command/ResetCdteStatusCommand.php

namespace TEW\TPBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
//use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ResetCdteStatusCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('tew:resetcdtestatus')
                ->setDescription('Unset "in process" status for candidates when their status is older than 15 days\n'.
                        'To be treated by a cron job');
//                ->addArgument('name', InputArgument::OPTIONAL, 'Qui voulez vous saluer??')
//                ->addOption('yell', null, InputOption::VALUE_NONE, 'Si définie, la tâche criera en majuscules')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $inprocess = $em->getRepository('TEWTPBundle:CdteStatus')->findOneByName('in process')->getId();
        $now = new \DateTime('NOW');
        $d15_old = new \DateTime('NOW - 15 days');
        
        $output->writeln($now->format('Y-m-d H:i:s')."> Resetting cdte statuses older than 15 days (".$d15_old->format('Y-m-d H:i:s').")\n");
        
        // This query is a bit tricky, since update + leftjoin (on statuses) is impossible in SQL
        // So we have to split the work into 2 steps: 1/ Select the candidates with a left join on statuses 2/ Update them
//        $qb = $em->getRepository('TEWTPBundle:Candidate')->createQueryBuilder('c')
//                ->update()
//                ->set('c.status', 'c.lastStatus')
//                ->set('c.statusDate', ':now')
//                ->where('c.status = :inprocess')
//                ->andWhere('c.statusDate < :d15_old')
//                ->setParameter('inprocess', $inprocess)
//                ->setParameter('now', $now)
//                ->setParameter('d15_old', $d15_old)
//            ;
        $qb_in = $em->getRepository('TEWTPBundle:Candidate')->createQueryBuilder('c')
                ->leftjoin('c.status','s')
                ->where('s.name = :inprocess')
                ->andWhere('c.statusDate < :d15_old')
                ->andWhere('c.lastStatus is not NULL')
                ->setParameter('inprocess', 'in process')
                ->setParameter('d15_old', $d15_old)
                ;
        $results = $qb_in->getQuery()->getResult();
        $idresults = array_map(function($cdte){ return $cdte->getId(); }, $results);
        
        if (count($results)==0){
            $output->writeln("No candidate status to update");
        } else {
            $cdtes = array_map(function($cdte){ return '('.$cdte->getId().') '.$cdte->getFirstName().' '.$cdte->getLastName(); }, $results);
            $output->writeln("Target candidates ".(print_r($cdtes, true)));

            $qb_update = $em->getRepository('TEWTPBundle:Candidate')->createQueryBuilder('cdte');
            $qb_update
                    ->update()
                    ->set('cdte.status', 'cdte.lastStatus')
                    ->set('cdte.statusDate', ':now')
                    ->where($qb_update->expr()->in('cdte', $idresults))
                    ->setParameter('now', $now)
                    ;
            $q = $qb_update->getQuery();
            $output->writeln($q->getSql());
            $p = $q->execute();
            $output->writeln('Done');
        }
    }

}
