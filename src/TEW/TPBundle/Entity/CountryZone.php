<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CountryZone
 *
 * @ORM\Table(name="tew_country_zone")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CountryZoneRepository")
 */
class CountryZone
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=7)
     */
    private $country;

    /**
     * @var zone
     *
     * @ORM\ManyToOne(targetEntity="Zone")
     * @ORM\JoinColumn(name="zone", nullable=false, referencedColumnName="id")
     */
    private $zone;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return CountryZone
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set zone
     *
     * @param string $zone
     * @return CountryZone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return string 
     */
    public function getZone()
    {
        return $this->zone;
    }
}
