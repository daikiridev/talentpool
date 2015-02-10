<?php
// src/MyProject/MyBundle/Entity/City.php

namespace TEW\TPBundle\Entity;

use DCS\Form\SelectCityFormFieldBundle\Entity\City as CityBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * CdteCity
 *
 * @ORM\Table(name="tew_cdtecity")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteCityRepository")
 */
class CdteCity extends CityBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
