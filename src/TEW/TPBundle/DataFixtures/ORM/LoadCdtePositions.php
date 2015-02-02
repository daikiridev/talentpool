<?php
/* We preload some predefined languages
 * (see shell command: $ php app/console doctrine:fixtures:load --fixtures="src/TEW/TPBundle/DataFixtures/ORM/" --append)
 */

namespace TEW\TPBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TEW\TPBundle\Entity\CdtePosition;

class LoadPosition implements FixtureInterface
{
  public function load(ObjectManager $em)
  {
    // we first create some functions
    $functionNames = array('quality', 'R&D', 'project', 'financial');
    foreach ($functionNames as $fname) {
      $function = new \TEW\TPBundle\Entity\CdteFunction();
      $function->setName($fname);
      $em->persist($function);
    }
    $em->flush(); // in order to use the CdteFunctionRepository below
    
    // then we create some levels
    $levelNames = array('director', 'manager');
    foreach($levelNames as $lname) {
        $level = new \TEW\TPBundle\Entity\CdteLevel();
        $level->setName($lname);
        $em->persist($level);
        
        // we combine possiblities to create all available positions
        $functions = $em->getRepository('TEWTPBundle:CdteFunction')->findAll();
        foreach($functions as $function) {
            $position = new CdtePosition();
            $position->setFunction($function)->setLevel($level);
            $position->setName($function->getName().' '.$level->getName());
            $em->persist($position);
        }
    }
    $em->flush(); // Saving them to DB
  }
}