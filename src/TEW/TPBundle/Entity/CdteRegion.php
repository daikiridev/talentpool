<?php
// src/MyProject/MyBundle/Entity/Region.php

namespace TEW\TPBundle\Entity;

use DCS\Form\SelectCityFormFieldBundle\Entity\Region as RegionBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * CdteRegion
 *
 * @ORM\Table(name="tew_cdteregion")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteRegionRepository")
 */
class CdteRegion extends RegionBase
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
