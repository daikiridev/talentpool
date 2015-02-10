<?php
// src/MyProject/MyBundle/Entity/Country.php

namespace TEW\TPBundle\Entity;

use DCS\Form\SelectCityFormFieldBundle\Entity\Country as CountryBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * CdteCountry
 *
 * @ORM\Table(name="tew_cdtecountry")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteCountryRepository")
 */
class CdteCountry extends CountryBase
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
