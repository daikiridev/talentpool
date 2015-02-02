<?php
/* We preload some predefined languages
 * (see shell command: $ php app/console doctrine:fixtures:load)
 */

namespace TEW\TPBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TEW\TPBundle\Entity\Language;

class LoadLanguage implements FixtureInterface
{
  public function load(ObjectManager $em)
  {
    // list of available languages
    $names = array('English', 'Mandarin', 'French', 'Spanish', 'Portugese', 'Italian', 'German', 'Russian', 'Hindi', 'Urdu');

    foreach ($names as $name) {
      $language = new Language();
      $language->setLanguage($name);
      $em->persist($language);
    }
    $em->flush(); // Saving them to DB
  }
}